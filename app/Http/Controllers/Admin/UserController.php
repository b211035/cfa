<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Response;
use App\User;
use App\TeacherUserRelation;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Users = DB::table('users')
        ->select('users.id', 'users.user_name')
        ->orderBy('users.id', 'asc')
        ->get();

        return view('admin.user')
        ->with('Users', $Users);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function log($id)
    {
        $User = User::find($id);
        $Logs = DB::table('logs')
        ->where('user_id', '=', $id)
        ->select('scenario_id')
        ->groupBy('scenario_id')
        ->get();


        $Scenarios = DB::table('scenarios')
        ->whereIn('id',
            DB::table('logs')
            ->where('user_id', '=', $id)
            ->select('scenario_id')
            ->groupBy('scenario_id')
        )
        ->get();

        return view('admin.log')
        ->with('User', $User)
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
        $Logs = DB::table('logs')
        ->join('bots', 'logs.bot_id', '=', 'bots.id')
        ->join('scenarios', 'logs.scenario_id', '=', 'scenarios.id')
        ->where('user_id', '=', $user_id)
        ->where('scenarios.id', '=', $scenario_id)
        ->get();

        return view('admin.log_scenario')
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
        $query = DB::table('logs')
        ->join('bots', 'logs.bot_id', '=', 'bots.id')
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
}
