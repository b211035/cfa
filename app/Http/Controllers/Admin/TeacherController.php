<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Teacher;

class TeacherController extends Controller
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
    public function index()
    {
        $Teachers = Teacher::all();

        return view('admin.teacher')
        ->with('Teachers', $Teachers);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function registForm(Request $request)
    {
        return view('admin.teacher_add');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function regist(Request $request)
    {
        $validatedData = $request->validate([
            'login_id' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Teacher::create([
            'login_id' => $request->input('login_id'),
            'user_name' => $request->input('user_name'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('admin_teacher');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $Teacher = Teacher::find($id);
        $Teacher->delete();
        return redirect()->route('admin_teacher');
    }
}
