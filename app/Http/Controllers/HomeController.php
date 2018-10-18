<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Scenario;
use App\Bot;
use App\Repluser;
use App\School;
use App\Stage;
use App\Log;

class HomeController extends Controller
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

        $Stages = Stage::with('Scenarios')
        ->join('teacher_user_relations', 'teacher_user_relations.teacher_id', '=', 'stages.teacher_id')
        ->where('teacher_user_relations.user_id', '=', $User->id)
        ->select(
            'stages.id',
            'stages.stage_name'
        )
        ->get();

        foreach ($Stages as $Stage) {
            $matrix =  [];
            foreach ($Stage->Scenarios as $Scenario) {
                $Scenario->haslog = DB::table('logs')->where('user_id', $User->id)->where('scenario_id', $Scenario->id)->exists();
                $matrix[$Scenario->times] = $Scenario;
            }
            $Stage->matrix = $matrix;
        }

        $LastScenarios = Scenario::join('logs', 'scenarios.id', '=', 'logs.scenario_id')
        ->select(
            'scenarios.id',
            'scenarios.scenario_name'
        )
        ->orderBy('logs.send_date', 'desc')
        ->first();

        return view('home')
        ->with('Stages', $Stages)
        ->with('LastScenarios', $LastScenarios);
    }

    public function talk($scenarioid)
    {
        $User = Auth::user();
        $Scenario = Scenario::find($scenarioid);

        $Bot = Bot::find($Scenario->bot_id);

        $UserAvatar = $User->Avatar;

        $Repluser = Repluser::where([ ['user_id', $User->id], ['bot_id', $Bot->id] ])->first();

        if (!$Repluser) {
            $api_key = $Bot->api_key;
            $header = ['Content-Type: application/json', 'x-api-key: '.$api_key];
            $body = ['botId' => $Bot->bot_id];

            $option = [
                CURLOPT_URL => 'https://api.repl-ai.jp/v1/registration',
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => $header,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => json_encode($body),
            ];

            $curl = curl_init();
            curl_setopt_array($curl, $option);
            $response = curl_exec($curl);
            $result = json_decode($response, true);
            curl_close($curl);

            $Repluser = Repluser::create([
                'user_id' => $User->id,
                'bot_id' => $Bot->id,
                'repl_user_id' => $result['appUserId'],
            ]);
        }

        $Logs = $this->getLog($User, null, $Scenario->stage_id);

        return view('talk')
        ->with('User', $User)
        ->with('Repluser', $Repluser)
        ->with('Scenario', $Scenario)
        ->with('Bot', $Bot)
        ->with('Logs', $Logs)
        ->with('UserAvatar', $UserAvatar);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function jsonLog(Request $request)
    {
        $User = Auth::user();

        $Logs = $this->getLog($User, $request->input('scenario_id'), $request->input('stage_id'));

        return response()->json($Logs);
    }

    public function getLog($User, $scenario_id = null, $stage_id = null){
        $query = Log::join('bots', 'logs.bot_id', '=', 'bots.id')
        ->join('scenarios', 'logs.scenario_id', '=', 'scenarios.id')
        ->join('stages', 'scenarios.stage_id', '=', 'stages.id')
        ->select(
            'scenarios.scenario_name',
            'bots.bot_name',
            'logs.sender_flg',
            'logs.contents',
            'logs.send_date',
            'logs.avater_image'
        )
        ->where('logs.user_id', '=', $User->id)
        ->orderBy('logs.id', 'asc');

        if ($scenario_id) {
            $query->where('logs.scenario_id', '=', $scenario_id);
        }

        if ($stage_id) {
            $query->where('stages.id', '=', $stage_id);
        }

        return $query->get();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function log($scenarioid)
    {
        $User = Auth::user();

        $Logs = $this->getLog($User, $scenarioid);

        return view('log')
        ->with('User', $User)
        ->with('Logs', $Logs);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function stageLog($stageid)
    {
        $User = Auth::user();

        $Logs = $this->getLog($User, null, $stageid);

        return view('log')
        ->with('User', $User)
        ->with('Logs', $Logs);
    }

    public function profile(){
        return view('profile');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function schoolRegistForm(Request $request)
    {
        $Schools = School::all();
        $User = Auth::user();

        return view('school')
        ->with('User', $User)
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

        $User = Auth::user();
        $User->school_id = $request->input('school_id');
        $User->save();

        return redirect()->route('profile');
    }
}
