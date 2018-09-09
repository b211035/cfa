<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $Scenarios = Scenario::all();

        return view('home')->with('Scenarios', $Scenarios);
    }

    public function talk($scenarioid)
    {
        $User = \Auth::user();
        $Scenario = Scenario::find($scenarioid);
        $Bot = Bot::find($Scenario->bot_id);

        return view('talk')
        ->with('User', $User)
        ->with('Scenario', $Scenario)
        ->with('Bot', $Bot);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function log()
    {
        $User = \Auth::user();
        $Logs = DB::table('logs')
        ->join('bots', 'logs.bot_id', '=', 'bots.id')
        ->join('scenarios', 'logs.scenario_id', '=', 'scenarios.id')
        ->where('user_id', '=', $User->id)->get();

        return view('log')
        ->with('User', $User)
        ->with('Logs', $Logs);
    }
}
