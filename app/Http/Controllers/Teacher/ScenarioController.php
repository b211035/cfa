<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Scenario;
use App\Bot;
use App\Stage;

class ScenarioController extends Controller
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

        $Scenarios = $Teacher->Scenarios;

        return view('teacher.scenario')
        ->with('Scenarios', $Scenarios);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function registForm(Request $request)
    {
        $Teacher = Auth::user();

        $Bots = $Teacher->Bots;

        $Stages = $Teacher->Stages;

        return view('teacher.scenario_add')
        ->with('Bots', $Bots)
        ->with('Stages', $Stages);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function regist(Request $request)
    {
        $Teacher = Auth::user();
        $validatedData = $request->validate([
            'scenario_id' => 'required|string|max:255',
            'scenario_name' => 'required|string|max:255',
            'bot_id' => 'required|exists:bots,id',
            'stage_id' => 'required|exists:stages,id',
            'times' => 'required|integer|min:1|max:4',
        ]);

        $Scenario = Scenario::create([
            'scenario_id' => $request->input('scenario_id'),
            'scenario_name' => $request->input('scenario_name'),
            'bot_id' => $request->input('bot_id'),
            'stage_id' => $request->input('stage_id'),
            'times' => $request->input('times'),
            'teacher_id' => $Teacher->id,
        ]);

        return redirect()->route('teacher_scenario');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateForm(Request $request, $id)
    {
        $Teacher = Auth::user();

        $Bots = $Teacher->Bots;

        $Stages = $Teacher->Stages;

        $Scenario = Scenario::find($id);
        return view('teacher.scenario_add')
        ->with('Bots', $Bots)
        ->with('Stages', $Stages)
        ->with('Scenario', $Scenario);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'scenario_id' => "required|string|max:255",
            'scenario_name' => 'required|string|max:255',
            'bot_id' => 'required|exists:bots,id',
            'stage_id' => 'required|exists:stages,id',
            'times' => 'required|integer|min:1|max:4',
        ]);

        $Scenario = Scenario::find($id);
        $Scenario->scenario_id = $request->input('scenario_id');
        $Scenario->scenario_name = $request->input('scenario_name');
        $Scenario->bot_id = $request->input('bot_id');
        $Scenario->stage_id = $request->input('stage_id');
        $Scenario->times = $request->input('times');
        $Scenario->save();

        return redirect()->route('teacher_scenario');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $Scenario = Scenario::find($id);
        $Scenario->delete();
        return redirect()->route('teacher_scenario');
    }
}
