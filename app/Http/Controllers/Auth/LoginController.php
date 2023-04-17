<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    // protected $fillable = ['email', 'password', 'user_type'];
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
//     protected function credentials(Request $request)
// {
//     return array_merge($request->only($this->username(), 'password'), ['user_type' => $request->user_type]);
// }
// public function showLoginForm()
//     {
//         return view('auth.login');
//     }
//     public function login(Request $request)
//     {
//         $credentials = $request->only('email', 'password');

//         if (Auth::attempt($credentials)) {
//             if (Auth::user()->isInstructor()) {
//                 return redirect()->route('instructor.dashboard');
//             } elseif (Auth::user()->isTrainee()) {
//                 return redirect()->route('trainee.dashboard');
//             } elseif (Auth::user()->isAdmin()) {
//                 return redirect()->route('admin.dashboard');
//             }
//         }

//         return redirect()->route('login')->withErrors(['email' => 'Invalid email or password.']);
//     }
}

