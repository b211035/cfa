<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Talktagtype;
use App\Talktag;

class TalktagController extends Controller
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
        $Talktagtypes = Talktagtype::all();

        return view('admin.talktagtype')
        ->with('Talktagtypes', $Talktagtypes);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function talktag($type_id)
    {
        $Talktagtype = Talktagtype::find($type_id);

        $Talktags = $Talktagtype->Talktags;

        return view('admin.talktag')
        ->with('Talktagtype', $Talktagtype)
        ->with('Talktags', $Talktags);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function registForm(Request $request, $type_id)
    {
        $Talktagtype = Talktagtype::find($type_id);

        return view('admin.talktag_add')
        ->with('Talktagtype', $Talktagtype);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function regist(Request $request, $type_id)
    {
        $validatedData = $request->validate([
            'protcol_name' => 'required|string|max:255',
            'protcol' => 'required|string|max:255',
        ]);

        Talktag::create([
            'talktagtype_id' => $type_id,
            'protcol_name' => $request->input('protcol_name'),
            'protcol' => $request->input('protcol'),
        ]);

        return redirect()->route('admin_talktag', $type_id);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($type_id, $id)
    {
        $Talktag = Talktag::find($id);
        $Talktag->delete();
        return redirect()->route('admin_talktag', $type_id);
    }
}
