<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Scenario;
use App\Bot;
use App\User;
use App\Stage;
use App\TeacherUserRelation;
use App\School;

class TeacherController extends Controller
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
        return view('teacher.home');
    }

    public function profile(){
        return view('teacher.profile');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function schoolRegistForm(Request $request)
    {
        $Schools = School::all();
        $Teacher = Auth::user();

        return view('teacher.school')
        ->with('Teacher', $Teacher)
        ->with('Schools', $Schools)
;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function schoolRegist(Request $request)
    {
        $validatedData = $request->validate([
            'school_id' => 'required|exists:schools,id',
        ]);

        $Teacher = Auth::user();
        $Teacher->school_id = $request->input('school_id');
        $Teacher->save();

        return redirect()->route('teacher_profile');
    }
}
