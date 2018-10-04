<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function username()
    {
        return 'login_id';
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $request->only($this->username(), 'password');
        if (Auth::guard('teacher')->attempt($credentials)) {
            return redirect()->route('teacher_home');
        }

        // 該当ログインIDのユーザーを検索
        $User = User::where($this->username(), $request->input($this->username()))->get()->first();

        if ($User && $User->cfa_flg != 1) {
            // ユーザー登録済みでＣＦＡ連携以外の場合
            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }
        } else {
            $header = ['Content-Type: application/json'];
            $body = [
                'username' => $request->input($this->username()),
                'password' => $request->input('password')
            ];

            $option = [
                CURLOPT_URL => 'http://dev.coachforall.jp/api/usercheck',
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

            if ($result['code'] == 200) {
                // CFAでログイン検証に成功した
                if ($User) {
                    // 連携済みならそのアカウントでログイン
                } else{
                    // 未連携ならアカウント作成
                    $User = User::create([
                        'login_id' => $result['user']['account'],
                        'user_name' => $result['user']['name'],
                        'cfa_flg' => 1,
                    ]);
                }
                Auth::login($User);
                return $this->sendLoginResponse($request);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

}
