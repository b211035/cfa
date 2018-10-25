<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Response;
use App\User;
use App\Scenario;
use App\Log;

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
        $Users = User::all();

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

        $Scenarios = Scenario::whereIn('id',
            Log::where('user_id', '=', $id)
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
    public function delete($id)
    {
        $User = User::find($id);
        $User->login_id = uniqid('deleted_', true);
        $User->save();
        $User->delete();
        return redirect()->route('admin_user');
    }
}
