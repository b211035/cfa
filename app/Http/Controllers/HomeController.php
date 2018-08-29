<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function repl()
    {

        return response()->json([
            'result' => true
        ]);
    }
}
