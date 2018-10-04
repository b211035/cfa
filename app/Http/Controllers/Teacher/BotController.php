<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Bot;

class BotController extends Controller
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
        $Bots = DB::table('bots')
        ->where('teacher_id', '=', $Teacher->id)
        ->orderBy('id', 'asc')
        ->get();

        return view('teacher.bot')->with('Bots', $Bots);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function registForm(Request $request)
    {
        return view('teacher.bot_add');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function regist(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'exists:bots,id',
            'bot_id' => 'required|string|max:255',
            'bot_name' => 'required|string|max:255',
        ]);

        $Teacher = Auth::user();

        $Bot = Bot::create([
            'bot_id' => $request->input('bot_id'),
            'bot_name' => $request->input('bot_name'),
            'teacher_id' => $Teacher->id,
        ]);
        return redirect()->route('teacher_bot');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateForm(Request $request, $id)
    {
        $Bot = Bot::find($id);
        return view('teacher.bot_add')
        ->with('Bot', $Bot);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'bot_id' => "required|string|max:255|unique:bots,bot_id,$id,id",
            'bot_name' => 'required|string|max:255',
        ]);

        $Bot = Bot::find($id);
        $Bot->bot_id = $request->input('bot_id');
        $Bot->bot_name = $request->input('bot_name');
        $Bot->save();

        return redirect()->route('teacher_bot');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        DB::table('bots')->where('id', '=', $id)->delete();
        return redirect()->route('teacher_bot');
    }
}
