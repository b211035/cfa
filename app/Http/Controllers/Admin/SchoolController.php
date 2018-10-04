<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\School;

class SchoolController extends Controller
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
        $Schools = School::all();

        return view('admin.school')
        ->with('Schools', $Schools);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function registForm(Request $request)
    {
        return view('admin.school_add');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function regist(Request $request)
    {
        $validatedData = $request->validate([
            'school_name' => 'required|string|max:255',
        ]);

        School::create([
            'school_name' => $request->input('school_name'),
        ]);

        return redirect()->route('admin_school');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        DB::table('schools')->where('id', '=', $id)->delete();
        return redirect()->route('admin_school');
    }
}
