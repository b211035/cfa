<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Scenario;
use App\Bot;
use App\Repluser;
use App\Log;

class ReplController extends Controller
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
}
