<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Response;
use App\User;
use App\UserClass;
use App\Scenario;
use App\Log;
use App\Theme;
use App\Question;
use App\Answer;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:teacher');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Teacher = Auth::user();
        $Users = $this->getUserList($Teacher);

        return view('teacher.user')
        ->with('Users', $Users);
    }

    public function getUserList($Teacher) {
        return User::leftjoin('teacher_user_relations', function ($join) {
            $Teacher = Auth::user();
            $join->on('teacher_user_relations.user_id', '=', 'users.id')
                ->where('teacher_user_relations.teacher_id', '=', $Teacher->id);
        })
        ->leftjoin('progress', 'users.id', '=', 'progress.user_id')
        ->whereNotNull('users.school_id')
        ->where('users.school_id', '=', $Teacher->school_id)
        ->select('users.id', 'users.user_name', 'teacher_user_relations.teacher_id', 'next_stage', 'next_scenario_id')
        ->orderBy('users.id', 'asc')
        ->get();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function enable($id)
    {
        $Teacher = Auth::user();

        $Teacher->Users()->attach($id);

        $Users = $this->getUserList($Teacher);
        $result = ['user' => $Users];

        return response()->json($result);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function disable($id)
    {
        $Teacher = Auth::user();

        $Teacher->Users()->detach($id);

        $Users = $this->getUserList($Teacher);
        $result = ['user' => $Users];

        return response()->json($result);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $Teacher = Auth::user();

        $User = User::find($id);
        $User->login_id = uniqid('deleted_', true);
        $User->save();
        $User->delete();

        $Users = $this->getUserList($Teacher);
        $result = ['user' => $Users];

        return response()->json($result);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function registForm(Request $request)
    {
        $Teacher = Auth::user();

        return view('teacher.user_add')
        ->with('Teacher', $Teacher);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function regist(Request $request)
    {
        $validatedData = $request->validate([
            'login_id' => 'unique:users|required|string|max:255',
            'user_name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'admission_year' => 'required|integer',
        ]);

        $Teacher = Auth::user();
        $User = User::create([
            'login_id' => $request->input('login_id'),
            'user_name' => $request->input('user_name'),
            'password' => Hash::make($request->input('password')),
            'admission_year' => $request->input('admission_year'),
            'cfa_flg' => 0,
            'school_id' => $Teacher->school_id,
        ]);

        $gradecalsses = $request->input('gradecalsses');
        foreach ($gradecalsses as $key => $value) {
            $UserClass = UserClass::create([
                'user_id' => $User->id,
                'grade_id' => $key,
                'class_id' => $value,
            ]);
        }

        $Teacher->Users()->attach($User->id);

        return redirect()->route('teacher_user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateForm(Request $request, $id)
    {
        $Teacher = Auth::user();
        $User = User::find($id);
        return view('teacher.user_add')
        ->with('Teacher', $Teacher)
        ->with('User', $User);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_name' => 'required|string|max:255',
            'admission_year' => 'required|integer',
        ]);

        $User = User::find($id);
        $User->user_name = $request->input('user_name');
        $User->admission_year = $request->input('admission_year');
        $User->save();


        $gradecalsses = $request->input('gradecalsses');
        foreach ($gradecalsses as $key => $value) {
            $UserClass = $User->Classes->where('grade_id', $key)->first();
            if ($UserClass) {
                $UserClass->class_id = $value;
                $UserClass->save();
            } else {
                $UserClass = UserClass::create([
                    'user_id' => $User->id,
                    'grade_id' => $key,
                    'class_id' => $value,
                ]);
            }
        }

        return redirect()->route('teacher_user');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function log($id)
    {
        $User = User::find($id);

        $Scenarios = Scenario::whereIn('id',
            Log::where('user_id', '=', $id)
            ->select('scenario_id')
            ->groupBy('scenario_id')
        )
        ->get();

        $Teacher = Auth::user();
        $Themes = $Teacher->Themes;

        return view('teacher.log')
        ->with('User', $User)
        ->with('Themes', $Themes)
        ->with('Scenarios', $Scenarios);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function logScenario($user_id, $scenario_id)
    {
        $User = User::find($user_id);
        $Logs = Log::join('bots', 'logs.bot_id', '=', 'bots.id')
        ->join('scenarios', 'logs.scenario_id', '=', 'scenarios.id')
        ->select(
            'scenarios.scenario_name',
            'bots.bot_name',
            'logs.sender_flg',
            'logs.contents',
            'logs.send_date',
            'logs.avater_image'
        )
        ->where('user_id', '=', $user_id)
        ->where('scenarios.id', '=', $scenario_id)
        ->get();

        return view('teacher.log_scenario')
        ->with('scenario_id', $scenario_id)
        ->with('User', $User)
        ->with('Logs', $Logs);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function logDownload($user_id, $scenario_id)
    {
        $query = Log::join('bots', 'logs.bot_id', '=', 'bots.id')
        ->join('scenarios', 'logs.scenario_id', '=', 'scenarios.id')
        ->join('users', 'logs.user_id', '=', 'users.id')
        ->select(
            'users.user_name',
            'scenarios.scenario_name',
            'bots.bot_name',
            'logs.sender_flg',
            'logs.contents',
            'logs.send_date'
        )
        ->where('users.id', '=', $user_id);

        if ($scenario_id > 0) {
            $query->where('scenarios.id', '=', $scenario_id);
        }

        $Logs = $query->get();

        $stream = fopen('php://temp', 'r+b');
        $csvHeader = ['生徒名', 'シナリオ名', 'ボット名', '発言者', '発言内容', '発言日時'];
        fputcsv($stream, $csvHeader);
        foreach ($Logs as $Log) {
            $log = json_decode(json_encode($Log), true);
            $log['scenario_name'] = "'".$log['scenario_name'];
            $log['sender_flg'] = ($log['sender_flg'] == 1) ? $log['bot_name'] : $log['user_name'];
            fputcsv($stream, $log);
        }
        rewind($stream);
        $csv = str_replace(PHP_EOL, "\r\n", stream_get_contents($stream));
        $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');

        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="log.csv"',
        );
        return Response::make($csv, 200, $headers);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function resetProgress($user_id)
    {
        $User = User::find($user_id);
        $Progress = $User->Progress;
        if ($Progress) {
            $Progress->next_scenario_id = null;
            $Progress->next_stage = null;
            $Progress->save();
        }

        $Teacher = Auth::user();
        $Users = $this->getUserList($Teacher);
        $result = ['user' => $Users];
        return response()->json($result);
    }

    public function ThemeAnswers($user_id, $theme_id){
        $Teacher = Auth::user();
        $User = User::find($user_id);
        $Theme = Theme::find($theme_id);
        $Bot = $Theme->Stages()->first()->Scenarios()->first()->Bot;

        $ReplValQuestions = $Theme->Questions()->where('question_type', 1)->get();

        $Repluser = $User->Replusers()->where('bot_id', $Bot->id)->first();
        $header = ['Content-Type: application/json', 'x-api-key: '. $Bot->api_key .''];

        $body = [
            'appUserId' => $Repluser->repl_user_id,
            'botId' => $Bot->bot_id,
            'voiceText' => 'init',
            'initTalkingFlag' => true,
            'initTopicId' => $Theme->answer_scenario_id,
        ];

        $option = [
            CURLOPT_URL => 'https://api.repl-ai.jp/v1/dialogue',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($body),
        ];
        $curl = curl_init();

        foreach ($ReplValQuestions as $ReplValQuestion) {
            curl_setopt_array($curl, $option);
            $response = curl_exec($curl);
            $result = json_decode($response, true);

            $Answer = Answer::where('user_id', $User->id)
                ->where('question_id', $ReplValQuestion->id)
                ->first();
            if (!$Answer) {
                Answer::create([
                    'user_id' => $User->id,
                    'question_id' => $ReplValQuestion->id,
                    'answer' => $result['systemText']['expression'],
                ]);
            }
            $body = [
                'appUserId' => $Repluser->repl_user_id,
                'botId' => $Bot->bot_id,
                'voiceText' => 'next',
            ];
            $option = [CURLOPT_POSTFIELDS => json_encode($body)];
        }

        $LogQuestions = $Theme->Questions()->where('question_type', 3)->get();

        foreach ($LogQuestions as $LogQuestion) {
            $Answer = Answer::where('user_id', $User->id)
                ->where('question_id', $LogQuestion->id)
                ->first();
            if (!$Answer) {
                $targetLog = Log::where('contents', 'like', '%'.$LogQuestion->protcol.'%')
                ->where('sender_flg', 1)
                ->latest('id')
                ->first();

                $AnswerLog = Log::where('id', '>', $targetLog->id)
                ->where('sender_flg', 0)
                ->oldest('id')
                ->first();

                Answer::create([
                    'user_id' => $User->id,
                    'question_id' => $LogQuestion->id,
                    'answer' => $AnswerLog->contents,
                ]);
            }
        }

        $QandA = $Theme->Questions()->leftJoin('answers', 'answers.question_id', '=', 'questions.id')
                ->where('user_id', $User->id)
                ->orderBy('questions.id', 'asc')
                ->get();

        return view('teacher.answers')
        ->with('User', $User)
        ->with('QandA', $QandA);
    }

    public function stageCheck()
    {
        $Teacher = Auth::user();

        $first = $Teacher->Stages()
                ->Join('progress', 'progress.next_stage', '=', 'stages.id')
                ->Join('users', 'users.id', '=', 'progress.user_id')
                ->select('stages.id as stage_id', 'stages.*', 'users.id as user_id', 'users.*');
        $stages = $Teacher->Stages()
                ->Join('scenarios', 'scenarios.stage_id', '=', 'stages.id')
                ->Join('progress', 'progress.next_scenario_id', '=', 'scenarios.id')
                ->Join('users', 'users.id', '=', 'progress.user_id')
                ->select('stages.id as stage_id', 'stages.*', 'users.id as user_id', 'users.*')
                ->union($first)
                ->orderBy('stage_id', 'asc')
                ->get();
// dd($stages);
        return view('teacher.user_stage_check')
        ->with('stages', $stages);
    }
}
