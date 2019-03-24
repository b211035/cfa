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
use App\Theme;
use App\Answer;
use App\UserClass;

class SchoolController extends Controller
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

        return view('teacher.school_manege')
        ->with('Teacher', $Teacher);
    }


    public function ThemeAnswers($theme_id){
        $Teacher = Auth::user();
        $Users = $this->getUserList($Teacher);
        $Theme = Theme::find($theme_id);
        $Bot = $Theme->Stages()->first()->Scenarios()->first()->Bot;

        foreach ($Users as $User) {
            $Repluser = $User->Replusers()->where('bot_id', $Bot->id)->first();
            if ($Repluser) {
                $ReplValQuestions = $Theme->Questions()->where('question_type', 1)->get();
                $header = ['Content-Type: application/json', 'x-api-key: '. $Bot->api_key .''];

                $body = [
                    'appUserId' => $Repluser->repl_user_id,
                    'botId' => $Bot->bot_id,
                    'voiceText' => 'init',
                    'initTalkingFlag' => true,
                    'initTopicId' => $Theme->answer_scenario_id,
                ];

                $option = [
                    CURLOPT_URL => 'https://api.repl-ai.jp/v1/dialogue',
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_HTTPHEADER => $header,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POSTFIELDS => json_encode($body),
                ];
                $curl = curl_init();

                foreach ($ReplValQuestions as $ReplValQuestion) {
                    curl_setopt_array($curl, $option);
                    $response = curl_exec($curl);
                    $result = json_decode($response, true);

                    $Answer = Answer::where('user_id', $User->id)
                        ->where('question_id', $ReplValQuestion->id)
                        ->first();
                    if (!$Answer) {
                        Answer::create([
                            'user_id' => $User->id,
                            'question_id' => $ReplValQuestion->id,
                            'answer' => $result['systemText']['expression'],
                        ]);
                    }
                    $body = [
                        'appUserId' => $Repluser->repl_user_id,
                        'botId' => $Bot->bot_id,
                        'voiceText' => 'next',
                    ];
                    $option = [CURLOPT_POSTFIELDS => json_encode($body)];
                }


                $LogQuestions = $Theme->Questions()->where('question_type', 3)->get();
                foreach ($LogQuestions as $LogQuestion) {
                    $Answer = Answer::where('user_id', $User->id)
                        ->where('question_id', $LogQuestion->id)
                        ->first();
                    if (!$Answer) {
                        $targetLog = Log::where('contents', 'like', '%'.$LogQuestion->protcol.'%')
                        ->where('sender_flg', 1)
                        ->latest('id')
                        ->first();

                        $AnswerLog = Log::where('id', '>', $targetLog->id)
                        ->where('sender_flg', 0)
                        ->oldest('id')
                        ->first();

                        Answer::create([
                            'user_id' => $User->id,
                            'question_id' => $LogQuestion->id,
                            'answer' => $AnswerLog->contents,
                        ]);
                    }
                }
            }
        }

        return view('teacher.theme_answers')
        ->with('Users', $Users)
        ->with('Theme', $Theme);
    }

    public function List($year, $grade_id, $class_id)
    {
        $Teacher = Auth::user();
        $Themes = $Teacher->Themes;

        return view('teacher.school_manege_list')
        ->with('year', $year)
        ->with('grade_id', $grade_id)
        ->with('class_id', $class_id)
        ->with('Teacher', $Teacher)
        ->with('Themes', $Themes);
    }

    public function ListThemeAnswers($year, $grade_id, $class_id, $theme_id){
        $Teacher = Auth::user();
        $Users = $this->getUserList($Teacher, $year, $grade_id, $class_id);
        $Theme = Theme::find($theme_id);
        $Bot = $Theme->Stages()->first()->Scenarios()->first()->Bot;

        foreach ($Users as $User) {
            $Repluser = $User->Replusers()->where('bot_id', $Bot->id)->first();
            if ($Repluser) {
                $ReplValQuestions = $Theme->Questions()->where('question_type', 1)->get();
                $header = ['Content-Type: application/json', 'x-api-key: '. $Bot->api_key .''];

                $body = [
                    'appUserId' => $Repluser->repl_user_id,
                    'botId' => $Bot->bot_id,
                    'voiceText' => 'init',
                    'initTalkingFlag' => true,
                    'initTopicId' => $Theme->answer_scenario_id,
                ];

                $option = [
                    CURLOPT_URL => 'https://api.repl-ai.jp/v1/dialogue',
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_HTTPHEADER => $header,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POSTFIELDS => json_encode($body),
                ];
                $curl = curl_init();

                foreach ($ReplValQuestions as $ReplValQuestion) {
                    curl_setopt_array($curl, $option);
                    $response = curl_exec($curl);
                    $result = json_decode($response, true);

                    $Answer = Answer::where('user_id', $User->id)
                        ->where('question_id', $ReplValQuestion->id)
                        ->first();
                    if (!$Answer) {
                        Answer::create([
                            'user_id' => $User->id,
                            'question_id' => $ReplValQuestion->id,
                            'answer' => $result['systemText']['expression'],
                        ]);
                    }
                    $body = [
                        'appUserId' => $Repluser->repl_user_id,
                        'botId' => $Bot->bot_id,
                        'voiceText' => 'next',
                    ];
                    $option = [CURLOPT_POSTFIELDS => json_encode($body)];
                }


                $LogQuestions = $Theme->Questions()->where('question_type', 3)->get();
                foreach ($LogQuestions as $LogQuestion) {
                    $Answer = Answer::where('user_id', $User->id)
                        ->where('question_id', $LogQuestion->id)
                        ->first();
                    if (!$Answer) {
                        $targetLog = Log::where('contents', 'like', '%'.$LogQuestion->protcol.'%')
                        ->where('sender_flg', 1)
                        ->latest('id')
                        ->first();

                        $AnswerLog = Log::where('id', '>', $targetLog->id)
                        ->where('sender_flg', 0)
                        ->oldest('id')
                        ->first();

                        Answer::create([
                            'user_id' => $User->id,
                            'question_id' => $LogQuestion->id,
                            'answer' => $AnswerLog->contents,
                        ]);
                    }
                }
            }
        }

        return view('teacher.theme_list_answers')
        ->with('year', $year)
        ->with('grade_id', $grade_id)
        ->with('class_id', $class_id)
        ->with('Users', $Users)
        ->with('Theme', $Theme);
    }

    public function getUserList($Teacher, $year = null, $grade_id = null, $class_id = null) {
        $Query = User::leftjoin('teacher_user_relations', function ($join) {
            $Teacher = Auth::user();
            $join->on('teacher_user_relations.user_id', '=', 'users.id')
                ->where('teacher_user_relations.teacher_id', '=', $Teacher->id);
        });

        if ($class_id > 0 && $grade_id) {
            $Query = $Query->leftjoin('user_classes', 'users.id', '=', 'user_classes.user_id')
            ->where('user_classes.grade_id', '=', $grade_id)
            ->where('user_classes.class_id', '=', $class_id);
        }
        if ($year && $grade_id) {
            $School = $Teacher->School;
            if ($School) {
                $nowYear = date('Y');
                $index = 0;
                foreach ($School->Grades as $Grade) {
                    if ($Grade->id == $grade_id) {
                        break;
                    }
                    $index ++;
                }
                $inYear = $year - $index;
                $Query = $Query->where('users.admission_year', '=', $inYear);
            }
        }
        $Query = $Query->whereNotNull('users.school_id')
        ->where('users.school_id', '=', $Teacher->school_id);

        $Query->select('users.id', 'users.user_name', 'teacher_user_relations.teacher_id')
        ->orderBy('users.id', 'asc');
        return $Query->get();
    }

}
