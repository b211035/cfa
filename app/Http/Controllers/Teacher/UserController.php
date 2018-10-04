<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        $Users = DB::table('users')
        ->leftjoin('teacher_user_relations', function ($join) {
            $Teacher = Auth::user();
            $join->on('teacher_user_relations.user_id', '=', 'users.id')
                ->where('teacher_user_relations.teacher_id', '=', $Teacher->id);
        })
        ->whereNotNull('users.school_id')
        ->where('users.school_id', '=', $Teacher->school_id)
        ->select('users.id', 'users.user_name', 'teacher_user_relations.teacher_id')
        ->orderBy('users.id', 'asc')
        ->get();

        return view('teacher.user')
        ->with('Users', $Users);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function registForm(Request $request)
    {
        return view('teacher.user_add');
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
        ]);

        $User = User::create([
            'login_id' => $request->input('login_id'),
            'user_name' => $request->input('user_name'),
            'password' => Hash::make($request->input('password')),
            'cfa_flg' => 0,
        ]);
        $Teacher = Auth::user();

        TeacherUserRelation::create([
            'user_id' => $User->id,
            'teacher_id' => $Teacher->id,
        ]);

        return redirect()->route('teacher_user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function relation($id)
    {
        $User = User::find($id);
        $Teacher = Auth::user();

        TeacherUserRelation::create([
            'user_id' => $User->id,
            'teacher_id' => $Teacher->id,
        ]);

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

        return view('teacher.log')
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
        ->select(
            'scenarios.scenario_name',
            'bots.bot_name',
            'logs.sender_flg',
            'logs.contents',
            'logs.send_date'
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
