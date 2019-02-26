<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Theme;

class ThemeController extends Controller
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

        $Themes = $Teacher->Themes;

        return view('teacher.theme')
        ->with('Themes', $Themes);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function registForm(Request $request)
    {
        return view('teacher.theme_add');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function regist(Request $request)
    {
        $validatedData = $request->validate([
            'theme_name' => 'required|string|max:255',
            'answer_scenario_id' => 'string|max:255',
        ]);

        $Teacher = Auth::user();
        $Theme = Theme::create([
            'teacher_id' => $Teacher->id,
            'theme_name' => $request->input('theme_name'),
            'answer_scenario_id' => $request->input('answer_scenario_id'),
        ]);

        return redirect()->route('teacher_theme');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateForm(Request $request, $id)
    {
        $Theme = Theme::find($id);
        return view('teacher.theme_add')
        ->with('Theme', $Theme);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'theme_name' => 'required|string|max:255',
            'answer_scenario_id' => 'string|max:255',
        ]);

        $Theme = Theme::find($id);
        $Theme->theme_name = $request->input('theme_name');
        $Theme->answer_scenario_id = $request->input('answer_scenario_id');
        $Theme->save();

        return redirect()->route('teacher_theme');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $Theme = Theme::find($id);
        $Theme->delete();
        return redirect()->route('teacher_theme');
    }
}
