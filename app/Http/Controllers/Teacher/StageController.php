<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Stage;

class StageController extends Controller
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

        $Stages = $Teacher->Stages;

        return view('teacher.stage')
        ->with('Stages', $Stages);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function registForm(Request $request)
    {
        return view('teacher.stage_add');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function regist(Request $request)
    {
        $validatedData = $request->validate([
            'stage_name' => 'required|string|max:255',
        ]);

        $Teacher = Auth::user();
        $Stage = Stage::create([
            'teacher_id' => $Teacher->id,
            'stage_name' => $request->input('stage_name'),
        ]);

        return redirect()->route('teacher_stage');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateForm(Request $request, $id)
    {
        $Stage = Stage::find($id);
        return view('teacher.stage_add')
        ->with('Stage', $Stage);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'stage_name' => 'required|string|max:255',
        ]);

        $Stage = Stage::find($id);
        $Stage->stage_name = $request->input('stage_name');
        $Stage->save();

        return redirect()->route('teacher_stage');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $Stage = Stage::find($id);
        $Stage->delete();
        return redirect()->route('teacher_stage');
    }

    public function nextStage(Request $request, $id){
        $Teacher = Auth::user();

        $Stages = $Teacher->Stages;
        $PrevStage = Stage::find($id);

        return view('teacher.next_stage')
        ->with('PrevStage', $PrevStage)
        ->with('Stages', $Stages);
    }

    public function addNextStage(Request $request, $prev_id){
        $next_id = $request->input('next_id');
        $PrevStage = Stage::find($prev_id);

        $level = $PrevStage->nextStages()->count() + 1;

        $PrevStage->nextStages()->attach($next_id, ['level' => $level]);
        return redirect()->route('teacher_next_stage', $prev_id);
    }


    public function deleteNextStage(Request $request, $prev_id, $next_id){
        $PrevStage = Stage::find($prev_id);

        $DeleteStage = $PrevStage->nextStages()->where('next_stage_id', '=', $next_id)->first();
        DB::table('stage_chains')
            ->where('level', '>', $DeleteStage->pivot->level)
            ->decrement('level');

        $PrevStage->nextStages()->detach($next_id);

        return redirect()->route('teacher_next_stage', $prev_id);
    }

}
