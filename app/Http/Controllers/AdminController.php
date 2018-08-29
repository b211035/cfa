<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Scenario;
use App\Bot;

class AdminController extends Controller
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
        return view('admin_home');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function bot()
    {
        $Bots = Bot::all();

        return view('admin_bot')->with('Bots', $Bots);
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
    public function scenario()
    {
        $Bots = Bot::all();
        $Scenarios = Scenario::all();

        return view('admin_scenario')
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
}
