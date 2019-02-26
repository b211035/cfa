<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Theme;
use App\Question;

class QuestionController extends Controller
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
    public function index($theme_id)
    {
        $Theme = Theme::find($theme_id);
        // $Question = $Theme->Question;
        return view('teacher.question')
        ->with('Theme', $Theme);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function registForm(Request $request, $theme_id)
    {
        $Theme = Theme::find($theme_id);
        return view('teacher.question_add')
        ->with('Theme', $Theme);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function regist(Request $request, $theme_id)
    {
        $validatedData = $request->validate([
            'question_type' => 'required|numeric|max:255',
            'question_name' => 'required|string|max:255',
            'protcol' => 'nullable|string|max:255',
        ]);

        Question::create([
            'theme_id' => $theme_id,
            'question_type' => $request->input('question_type'),
            'question_name' => $request->input('question_name'),
            'protcol' => $request->input('protcol'),
        ]);

        return redirect()->route('teacher_question', $theme_id);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($theme_id, $id)
    {
        $Question = Question::find($id);
        $Question->delete();
        return redirect()->route('teacher_question', $theme_id);
    }
}
