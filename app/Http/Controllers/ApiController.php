<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Scenario;
use App\Bot;
use App\Repluser;
use App\Log;

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
        $api_key = \Config::get('const.api_key');

        $User = User::find($request->input('user_id'));
        $Bot = Bot::find($request->input('bot_id'));
        $Scenario = Scenario::find($request->input('scenario_id'));

        $Repluser = Repluser::where([ ['user_id', $User->id], ['bot_id', $Bot->id] ])->first();

        if (!$Repluser) {
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
            $result = json_decode($response, true);
            curl_close($curl);

            $Repluser = Repluser::create([
                'user_id' => $User->id,
                'bot_id' => $Bot->id,
                'repl_user_id' => $result['appUserId'],
            ]);
        }

        $contents = $request->input('contents');
        $Date = new \Datetime();
        if ($contents != 'init') {
            Log::create([
                'user_id' => $User->id,
                'bot_id' => $Bot->id,
                'scenario_id' => $Scenario->id,
                'sender_flg' => 0,
                'contents' => $contents,
                'send_date' => $Date->format('Y-m-d H:i:s')
            ]);
        }

        $header = ['Content-Type: application/json', 'x-api-key: '.$api_key];
        $body = [
            'appUserId' => $Repluser->repl_user_id,
            'botId' => $Bot->bot_id,
            'voiceText' => $contents,
            'initTalkingFlag' => ($contents == 'init') ?? true || false,
            'initTopicId' => $Scenario->scenario_id,
        ];

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

        Log::create([
            'user_id' => $User->id,
            'bot_id' => $Bot->id,
            'scenario_id' => $Scenario->id,
            'sender_flg' => 1,
            'contents' => $result['systemText']['expression'],
            'send_date' => $result['serverSendTime']
        ]);

        return response()->json($result);
    }

    public function scenario(Request $request)
    {
        $api_token = \Config::get('const.api_token');
        if ($api_token != $request->input('api_token')) {
            return response()->json([]);
        }

        $query = DB::table('scenarios')
        ->orderBy('scenarios.id', 'asc');

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

        $query = DB::table('logs')
        ->orderBy('logs.id', 'asc');

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

        $query = DB::table('bots')
        ->orderBy('bots.id', 'asc');

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

        $query = DB::table('users')
        ->orderBy('users.id', 'asc');

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
}
