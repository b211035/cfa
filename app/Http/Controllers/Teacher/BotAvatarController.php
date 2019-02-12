<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Bot;
use App\BotAvatar;
use App\Talktag;

class BotAvatarController extends Controller
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

        $BotAvatars = BotAvatar::join('talktags', 'bot_avatars.emotion', '=', 'talktags.protcol')
        ->orderBy('bot_avatars.id', 'asc')
        ->select(
            'bot_avatars.id',
            'bot_avatars.filename',
            'bot_avatars.protcol',
            'bot_avatars.emotion',
            'talktags.protcol_name'
        )
        ->where('bot_avatars.teacher_id', '=', $Teacher->id)
        ->get();

        return view('teacher.bot_avatar')
        ->with('BotAvatars', $BotAvatars);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function registForm(Request $request)
    {
        $Talktags = Talktag::all();

        return view('teacher.bot_avatar_add')
        ->with('Talktags', $Talktags);
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
            'protcol' => 'required|string',
            'emotion' => 'required|string',
            'avatar' => 'required|file|image',
        ]);

        $path = $request->file('avatar')->store('public/bot');
        $cutpath = explode('/', $path);
        $filename = array_pop($cutpath);

        $BotAvatars = BotAvatar::create([
            'protcol' => $request->input('protcol'),
            'emotion' => $request->input('emotion'),
            'filename' => $filename,
            'teacher_id' => $Teacher->id,
        ]);
        return redirect()->route('teacher_bot_avatar');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateForm(Request $request, $id)
    {
        $Bot = Bot::find($id);

        $Talktags = Talktag::all();

        return view('teacher.bot_avatar_add')
        ->with('Talktags', $Talktags)
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

        return redirect()->route('teacher_bot_avatar', $bot_id);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($avatar_id)
    {
        $BotAvatar = BotAvatar::find($avatar_id);
        // Storage::delete('public/bot/'.$BotAvatar->filename);

        $BotAvatar->delete();
        return redirect()->route('teacher_bot_avatar');
    }
}
