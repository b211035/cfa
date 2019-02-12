<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Scenario;
use App\Bot;
use App\Repluser;
use App\Log;
use App\UserAvatar;
use App\BotAvatar;
use App\Finished;
use App\Stop;
use App\Stage;
use App\Progress;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function repl(Request $request)
    {

        $Repluser = Repluser::where([ ['repl_user_id', $request->input('user_id')] ])->first();
        $User = User::where([ ['id', $Repluser->user_id] ])->first();

        $BotAndScenario = Scenario::join('bots', 'scenarios.bot_id', '=', 'bots.id')
        ->join('teacher_user_relations', 'scenarios.teacher_id', '=', 'teacher_user_relations.teacher_id')
        ->where('teacher_user_relations.user_id', '=', $User->id)
        ->where('bots.bot_id', '=', $request->input('bot_id'))
        ->where('scenarios.scenario_id', '=', $request->input('scenario_id'))
        ->select(
            'scenarios.teacher_id',
            'scenarios.id as sid',
            'scenarios.scenario_id',
            'bots.id as bid',
            'bots.bot_id',
            'bots.api_key'
        )
        ->first();

        $api_key = $BotAndScenario->api_key;

        $DefaultUserAvatar = UserAvatar::where('user_id', '=', $User->id)
        ->where('protcol', '=', '0')
        ->first();

        if ($DefaultUserAvatar) {
            $user_image = route('root') . '/storage/user/'.$DefaultUserAvatar->filename;
        } else {
            $user_image = route('root') . '/storage/default_avatar.png';
        }

        $contents = $request->input('contents');
        $Date = new \Datetime();
        if ($contents != 'init') {
            $save_contents = $contents;
            if ($contents == 'back') {
                $save_contents = '[戻る]';
            }

            Log::create([
                'user_id' => $User->id,
                'bot_id' => $BotAndScenario->bid,
                'scenario_id' => $BotAndScenario->sid,
                'sender_flg' => 0,
                'contents' => $save_contents,
                'contents_org' => $contents,
                'avater_image' => $user_image,
                'send_date' => $Date->format('Y-m-d H:i:s')
            ]);
        } else {
            DB::table('stops')->where('user_id', $User->id)
                ->where('scenario_id', $BotAndScenario->sid)
                ->delete();
        }

        $header = ['Content-Type: application/json', 'x-api-key: '.$api_key];
        $body = [
            'appUserId' => $Repluser->repl_user_id,
            'botId' => $BotAndScenario->bot_id,
            'voiceText' => $contents,
            'initTalkingFlag' => ($contents == 'init') ?? true || false,
        ];
        if ($body['initTalkingFlag']) {
            $body['initTopicId'] = $BotAndScenario->scenario_id;
        }

        $option = [
            CURLOPT_URL => 'https://api.repl-ai.jp/v1/dialogue',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($body),
        ];

        $curl = curl_init();
        curl_setopt_array($curl, $option);
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        curl_close($curl);

        $DefaultAvatar = BotAvatar::where('teacher_id', '=', $BotAndScenario->teacher_id)
        ->where('protcol', '=', '0')
        ->first();

        if ($DefaultAvatar) {
            $result['avatarImage'] = route('root') . '/storage/bot/'.$DefaultAvatar->filename;
        } else {
            $result['avatarImage'] = route('root') . '/storage/default_avatar.png';
        }

        $expression = $result['systemText']['expression'];

        if ($expression == 'NOMATCH') {
            switch (rand(1,3)) {
                case 1:
                    $expression = 'ごめん、俺まだ勉強不足じゃけ言い方かえてくれん?\s03';
                    break;
                case 2:
                    $expression= 'わかりまっしぇーーーーーーん！\s03';
                    break;
                default:
                    $expression = 'その言葉初めて聞いたわ、違う言葉でいってくれん？\s03';
                    break;
            }
        }


        if (preg_match('/\\\next\d+/u', $expression, $matches)) {
            $expression = str_replace($matches[0], '', $expression);
            $protcol = str_replace('\next', '', $matches[0]);


            if ($User->Progress) {
                $Progress = $User->Progress;
            } else {
                $Progress = Progress::create ([
                    'user_id' => $User->id,
                ]);
            }

            $Progress->next_stage = (int)$protcol;
            $Progress->save();
        }


        if (strpos($expression, '\end')) {
            $expression = str_replace('\end2', '', $expression);
            $expression = str_replace('\end', '', $expression);

            $Finished = Finished::where('user_id', $User->id)
                ->where('scenario_id', $BotAndScenario->sid)
                ->first();
            if (!$Finished) {
                Finished::create([
                    'user_id' => $User->id,
                    'scenario_id' => $BotAndScenario->sid,
                ]);
            }

            $NowScenario = Scenario::find($BotAndScenario->sid);
            $nextScenario = Scenario::where('times', '=', $NowScenario->times + 1)->where('stage_id', '=', $NowScenario->stage_id)->first();
            if ($User->Progress) {
                $Progress = $User->Progress;
            } else {
                $Progress = Progress::create ([
                    'user_id' => $User->id,
                ]);
            }

            if ($nextScenario) {
                // 同じステージに次のシナリオがあるなら選択
                $Progress->next_scenario_id = $nextScenario->id;
            } else {
                // 同じステージに次のシナリオがないなら次のステージへ
                $nextStageDefault = $NowScenario->Stage->nextStages()->first();

                if ($nextStageDefault) {
                    // 次のステージがあれば分岐を処理する
                    $nextStage = $NowScenario->Stage->nextStages()->where('level', '=', $Progress->next_stage)->first();
                    if (!$nextStage) {
                        $nextStage = $nextStageDefault;
                    }

                    // 次のシナリオＩＤを保持
                    $nextScenario = $nextStage->Scenarios()->where('times', '=', '1')->first();
                    if ($nextScenario) {
                        $Progress->next_scenario_id = $nextScenario->id;
                    } else {
                        $Progress->next_scenario_id = null;
                    }
                } else {
                    // 次のステージがなければ進行をリセット
                    $Progress->next_scenario_id = null;
                }
                $Progress->next_stage = null;
            }
            $Progress->save();
        }

        if (strpos($expression, '\stop')) {
            $expression = str_replace('\stop', '', $expression);
            Stop::create([
                'user_id' => $User->id,
                'scenario_id' => $BotAndScenario->sid,
            ]);
        }

        if (preg_match_all("/(https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/", $expression, $matches)) {
            foreach ($matches[0] as $matche) {
                $expression = str_replace($matche, '<a href="'.$matche.'" target="_blank">'.$matche.'</a>', $expression);
            }
        }

        if (preg_match('/\\\s\d+/u', $expression, $matches)) {
            $expression = str_replace($matches[0], '', $expression);
            $protcol = str_replace('\s', '', $matches[0]);
            $BotAvatar = BotAvatar::where('teacher_id', '=', $BotAndScenario->teacher_id)
            ->where('protcol', '=', (int)$protcol)
            ->first();
            if ($BotAvatar) {
                $result['avatarImage'] = route('root') . '/storage/bot/'.$BotAvatar->filename;
            }
        }

        $expression = str_replace('\n', '<br>', $expression);

        Log::create([
            'user_id' => $User->id,
            'bot_id' => $BotAndScenario->bid,
            'scenario_id' => $BotAndScenario->sid,
            'sender_flg' => 1,
            'contents' => $expression,
            'contents_org' => $result['systemText']['expression'],
            'avater_image' => $result['avatarImage'],
            'send_date' => $result['serverSendTime']
        ]);

        $result['systemText']['expression_org'] = $result['systemText']['expression'];
        $result['systemText']['expression'] = $expression;

        return response()->json($result);
    }

    public function scenario(Request $request)
    {
        $api_token = \Config::get('const.api_token');
        if ($api_token != $request->input('api_token')) {
            return response()->json([]);
        }

        $query = Scenario::orderBy('scenarios.id', 'asc');

        if ($request->input('id')) {
            $query->where('scenarios.id', '=', $request->input('id'));
        }

        if ($request->input('scenario_id')) {
            $query->where('scenarios.scenario_id', '=', $request->input('scenario_id'));
        }

        if ($request->input('scenario_name')) {
            $query->where('scenarios.scenario_name', '=', $request->input('scenario_name'));
        }

        if ($request->input('bot_id')) {
            $query->where('scenarios.bot_id', '=', $request->input('bot_id'));
        }

        if ($request->input('times')) {
            $query->where('scenarios.times', '=', $request->input('times'));
        }

        if ($request->input('stage_id')) {
            $query->where('scenarios.stage_id', '=', $request->input('stage_id'));
        }

        if ($request->input('teacher_id')) {
            $query->where('scenarios.teacher_id', '=', $request->input('teacher_id'));
        }

        $Scenarios = $query->get();

        return response()->json($Scenarios);
    }

    public function log(Request $request)
    {
        $api_token = \Config::get('const.api_token');
        if ($api_token != $request->input('api_token')) {
            return response()->json([]);
        }

        $query = Log::orderBy('logs.id', 'asc');

        if ($request->input('id')) {
            $query->where('logs.id', '=', $request->input('id'));
        }

        if ($request->input('user_id')) {
            $query->where('logs.user_id', '=', $request->input('user_id'));
        }

        if ($request->input('bot_id')) {
            $query->where('logs.bot_id', '=', $request->input('bot_id'));
        }

        if ($request->input('scenario_id')) {
            $query->where('logs.scenario_id', '=', $request->input('scenario_id'));
        }

        if ($request->input('sender_flg')) {
            $query->where('logs.sender_flg', '=', $request->input('sender_flg'));
        }

        if ($request->input('contents')) {
            $query->where('logs.contents', '=', $request->input('contents'));
        }

        if ($request->input('send_date')) {
            $query->where('logs.send_date', '=', $request->input('send_date'));
        }

        $Logs = $query->get();

        return response()->json($Logs);
    }

    public function bot(Request $request)
    {
        $api_token = \Config::get('const.api_token');
        if ($api_token != $request->input('api_token')) {
            return response()->json([]);
        }

        $query = Bot::orderBy('bots.id', 'asc');

        if ($request->input('id')) {
            $query->where('bots.id', '=', $request->input('id'));
        }

        if ($request->input('bot_id')) {
            $query->where('bots.bot_id', '=', $request->input('bot_id'));
        }

        if ($request->input('bot_name')) {
            $query->where('bots.bot_name', '=', $request->input('bot_name'));
        }

        if ($request->input('teacher_id')) {
            $query->where('bots.teacher_id', '=', $request->input('teacher_id'));
        }

        $Bots = $query->get();

        return response()->json($Bots);
    }

    public function user(Request $request)
    {
        $api_token = \Config::get('const.api_token');
        if ($api_token != $request->input('api_token')) {
            return response()->json([]);
        }

        $query = User::orderBy('users.id', 'asc');

        if ($request->input('id')) {
            $query->where('users.id', '=', $request->input('id'));
        }

        if ($request->input('login_id')) {
            $query->where('users.login_id', '=', $request->input('login_id'));
        }

        if ($request->input('user_name')) {
            $query->where('users.user_name', '=', $request->input('user_name'));
        }

        if ($request->input('password')) {
            $query->where('users.password', '=', Hash::make($request->input('password')));
        }

        if ($request->input('cfa_flg')) {
            $query->where('users.cfa_flg', '=', $request->input('cfa_flg'));
        }

        $User = $query->get();

        return response()->json($User);
    }

    public function userCheck(Request $request) {
        $data = $request->input();

        // 該当ログインIDのユーザーを検索
        $User = User::where('login_id', $data['username'])->get()->first();

        if ($User && $User->cfa_flg != 1) {
            $credentials = [
                'login_id' => $data['username'],
                'password' => $data['password']
            ];

            // ユーザー登録済みでＣＦＡ連携以外の場合
            if (Auth::once($credentials)) {

            } else {
                return response()->json(['code' => 404, 'user' => []]);
            }
        } else {
            $header = ['Content-Type: application/json'];
            $body = [
                'username' => $data['username'],
                'password' => $data['password']
            ];

            $cfa_url = \Config::get('const.cfa_url').'/api/usercheck';
            $option = [
                CURLOPT_URL => $cfa_url,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => $header,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => json_encode($body),
            ];

            $curl = curl_init();
            curl_setopt_array($curl, $option);
            $response = curl_exec($curl);
            $result = json_decode($response, true);
            curl_close($curl);

            if ($result['code'] == 200) {
                // CFAでログイン検証に成功した
                if ($User) {
                    // 連携済みならそのアカウントでログイン
                } else{
                    // 未連携ならアカウント作成
                    $User = User::create([
                        'login_id' => $result['user']['account'],
                        'user_name' => $result['user']['name'],
                        'cfa_flg' => 1,
                    ]);
                }
            } else {
                return response()->json(['code' => 404, 'user' => []]);
            }
        }

        $result = [
            'user_id' => $User->login_id,
            'user_name' => $User->user_name
        ];

        $query = Bot::join('teacher_user_relations', 'bots.teacher_id', '=', 'teacher_user_relations.teacher_id')
            ->where('teacher_user_relations.user_id', '=', $User->id)
            ->select(
                'bots.id',
                'bots.bot_id',
                'bots.bot_name'
            )
            ->orderBy('bots.id', 'asc');
        $Bots = $query->get();

        foreach ($Bots as $Bot) {
            $Repluser = Repluser::where([ ['user_id', $User->id], ['bot_id', $Bot->id] ])->first();

            if (!$Repluser) {
                $api_key = \Config::get('const.api_key');
                $header = ['Content-Type: application/json', 'x-api-key: '.$api_key];
                $body = ['botId' => $Bot->bot_id];

                $option = [
                    CURLOPT_URL => 'https://api.repl-ai.jp/v1/registration',
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_HTTPHEADER => $header,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POSTFIELDS => json_encode($body),
                ];

                $curl = curl_init();
                curl_setopt_array($curl, $option);
                $response = curl_exec($curl);
                $apiresult = json_decode($response, true);
                curl_close($curl);

                if (isset($apiresult['appUserId'])) {
                    $Repluser = Repluser::create([
                        'user_id' => $User->id,
                        'bot_id' => $Bot->id,
                        'repl_user_id' => $apiresult['appUserId'],
                    ]);
                } else {
                    $Repluser = new \stdClass();
                    $Repluser->repl_user_id = null;
                }
            }
            $Bot->repl_user_id = $Repluser->repl_user_id;

            $query = Stage::join('teacher_user_relations', 'stages.teacher_id', '=', 'teacher_user_relations.teacher_id')
                ->select(
                    'stages.id',
                    'stages.stage_name'
                )
                ->where('teacher_user_relations.user_id', '=', $User->id)
                ->orderBy('stages.id', 'asc');
            $Stages = $query->get();

            foreach ($Stages as $Stage) {
                $query = Scenario::select(
                        'id',
                        'scenario_id',
                        'scenario_name',
                        'times'
                    )
                    ->where('stage_id', '=', $Stage->id)
                    ->orderBy('scenarios.id', 'asc');
                $Scenarios = $query->get();

                foreach ($Scenarios as $Scenario) {
                    $query = Log::select(
                            'sender_flg',
                            'contents',
                            'send_date'
                        )
                        ->where('user_id', '=', $User->id)
                        ->where('scenario_id', '=', $Scenario->id)
                        ->orderBy('logs.id', 'asc');
                    $Logs = $query->get();

                    $Scenario->stop = Stop::where('user_id', $User->id)
                        ->where('scenario_id', $Scenario->id)
                        ->exists();
                    $Scenario->finished = Finished::where('user_id', $User->id)
                        ->where('scenario_id', $Scenario->id)
                        ->exists();

                    $Scenario->logs = $Logs;
                }
                $Stage->scenarios = $Scenarios;
            }
            $Bot->stages = $Stages;
        }

        $result['bots'] = $Bots;

        return response()->json(['code' => 200, 'user' => $result]);
    }
}
