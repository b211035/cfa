<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\GradeClass;
use App\School;

class ClassController extends Controller
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
        // $GradeClasss = $School->GradeClasss;

        return view('admin.class')
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
        return view('admin.class_add')
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
            'class_name' => 'required|string|max:255',
        ]);

        GradeClass::create([
            'school_id' => $school_id,
            'class_name' => $request->input('class_name'),
        ]);

        return redirect()->route('admin_class', $school_id);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($school_id, $id)
    {
        $GradeClass = GradeClass::find($id);
        $GradeClass->delete();
        return redirect()->route('admin_class', $school_id);
    }
}
