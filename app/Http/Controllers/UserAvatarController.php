<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\UserAvatar;

class UserAvatarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $User = Auth::user();
        $UserAvatar = $User->Avatar;

        return view('user_avatar')
        ->with('UserAvatar', $UserAvatar);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function registForm(Request $request)
    {
        return view('user_avatar_add');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function regist(Request $request)
    {
        $User = Auth::user();
        $validatedData = $request->validate([
            'avatar' => 'required|file|image',
        ]);

        $path = $request->file('avatar')->store('public/user');
        $cutpath = explode('/', $path);
        $filename = array_pop($cutpath);

        $UserAvatar = UserAvatar::create([
            'user_id' => $User->id,
            'protcol' => 0,
            'filename' => $filename,
        ]);
        return redirect()->route('user_avatar');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateForm(Request $request, $id)
    {
        return view('user_avatar_add');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => "required|string|max:255|unique:bots,user_id,$id,id",
            'bot_name' => 'required|string|max:255',
        ]);

        $Bot = Bot::find($id);
        $Bot->user_id = $request->input('user_id');
        $Bot->bot_name = $request->input('bot_name');
        $Bot->save();

        return redirect()->route('user_avatar');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($avatar_id)
    {
        $UserAvatar = UserAvatar::find($avatar_id);
        // Storage::delete('public/user/'.$UserAvatar->filename);

        $UserAvatar->delete();
        return redirect()->route('user_avatar');
    }
}
