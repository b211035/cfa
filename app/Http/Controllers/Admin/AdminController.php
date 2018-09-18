<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Scenario;
use App\Bot;
use App\User;
use App\Teacher;

class AdminController extends Controller
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
        return view('admin.home');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function bot()
    {
        $Bots = Bot::all();

        return view('admin.bot')->with('Bots', $Bots);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function botRegist(Request $request)
    {
        $validatedData = $request->validate([
            'bot_id' => 'unique:bots|required|string|max:255',
            'bot_name' => 'required|string|max:255',
        ]);

        Bot::create([
            'bot_id' => $request->input('bot_id'),
            'bot_name' => $request->input('bot_name'),
        ]);

        return redirect()->route('admin_bot');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function botDelete($id)
    {
        DB::table('bots')->where('id', '=', $id)->delete();
        return redirect()->route('admin_bot');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function scenario()
    {
        $Bots = Bot::all();
        $Scenarios = Scenario::all();

        return view('admin.scenario')
        ->with('Bots', $Bots)
        ->with('Scenarios', $Scenarios);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function scenarioRegist(Request $request)
    {
        $validatedData = $request->validate([
            'scenario_id' => 'unique:scenarios|required|string|max:255',
            'scenario_name' => 'required|string|max:255',
            'bot_id' => 'required|exists:bots,id',
        ]);

        $Scenario = Scenario::create([
            'scenario_id' => $request->input('scenario_id'),
            'scenario_name' => $request->input('scenario_name'),
            'bot_id' => $request->input('bot_id'),
        ]);

        return redirect()->route('admin_scenario');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function scenarioDelete($id)
    {
        DB::table('scenarios')->where('id', '=', $id)->delete();
        return redirect()->route('admin_scenario');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function user()
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
    public function userLog($id)
    {
        $User = User::find($id);
        $Logs = DB::table('logs')
        ->join('bots', 'logs.bot_id', '=', 'bots.id')
        ->join('scenarios', 'logs.scenario_id', '=', 'scenarios.id')
        ->where('user_id', '=', $id)->get();

        return view('admin.log')
        ->with('User', $User)
        ->with('Logs', $Logs);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function teacher()
    {
        $Teachers = Teacher::all();

        return view('admin.teacher')
        ->with('Teachers', $Teachers);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function teacherRegist(Request $request)
    {
        $validatedData = $request->validate([
            'login_id' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Teacher::create([
            'login_id' => $request->input('login_id'),
            'user_name' => $request->input('user_name'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('admin_teacher');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function teacherDelete($id)
    {
        DB::table('teachers')->where('id', '=', $id)->delete();
        return redirect()->route('admin_teacher');
    }
}
