<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Scenario;
use App\Bot;
use App\Repluser;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $User = Auth::user();
        $subquery = DB::table('logs')
           ->select(DB::raw('scenario_id, count(*) as haslog'))
           ->where('user_id', '=', $User->id)
           ->groupBy('scenario_id');

        $Scenarios = DB::table('scenarios')
        ->join('stages', 'scenarios.stage_id', '=', 'stages.id')
        ->join('teacher_user_relations', function ($join) {
            $User = Auth::user();
            $join->on('teacher_user_relations.teacher_id', '=', 'stages.teacher_id')
                ->where('teacher_user_relations.user_id', '=', $User->id);
        })
        ->leftJoinSub($subquery, 'logs', function($join) {
            $join->on('logs.scenario_id', '=', 'scenarios.id');
        })
        ->select(
            'scenarios.id',
            'scenarios.scenario_name',
            'scenarios.times',
            'scenarios.stage_id',
            'stages.stage_name',
            'logs.haslog'
        )
        ->orderBy('scenarios.id', 'asc')
        ->get();

        $matrix = [];
        foreach ($Scenarios as $Scenario) {
            $matrix[$Scenario->stage_id][$Scenario->times] = $Scenario;
        }


        return view('home')->with('matrix', $matrix);
    }

    public function talk($scenarioid)
    {
        $User = Auth::user();
        $Scenario = Scenario::find($scenarioid);

        $Bot = Bot::find($Scenario->bot_id);

        $UserAvatar = DB::table('user_avatars')
        ->where('user_id', '=', $User->id)
        ->orderBy('id', 'asc')
        ->first();

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

        return view('talk')
        ->with('User', $User)
        ->with('Repluser', $Repluser)
        ->with('Scenario', $Scenario)
        ->with('Bot', $Bot)
        ->with('UserAvatar', $UserAvatar);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function log($scenarioid)
    {
        $User = Auth::user();
        $Logs = DB::table('logs')
        ->join('bots', 'logs.bot_id', '=', 'bots.id')
        ->join('scenarios', 'logs.scenario_id', '=', 'scenarios.id')
        ->select(
            'scenarios.scenario_name',
            'bots.bot_name',
            'logs.sender_flg',
            'logs.contents',
            'logs.send_date'
        )
        ->where('logs.user_id', '=', $User->id)
        ->where('logs.scenario_id', '=', $scenarioid)
        ->get();

        return view('log')
        ->with('User', $User)
        ->with('Logs', $Logs);
    }
}
