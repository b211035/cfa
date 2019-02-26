<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\School;
use App\Grade;

class GradeController extends Controller
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
    public function index($school_id)
    {
        $School = School::find($school_id);
        // $Grades = $School->Grades;

        return view('admin.grade')
        ->with('School', $School);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function registForm(Request $request, $school_id)
    {
        $School = School::find($school_id);
        return view('admin.grade_add')
        ->with('School', $School);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function regist(Request $request, $school_id)
    {
        $validatedData = $request->validate([
            'grade_name' => 'required|string|max:255',
        ]);

        Grade::create([
            'school_id' => $school_id,
            'grade_name' => $request->input('grade_name'),
        ]);

        return redirect()->route('admin_grade', $school_id);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($school_id, $id)
    {
        $Grade = Grade::find($id);
        $Grade->delete();
        return redirect()->route('admin_grade', $school_id);
    }
}
