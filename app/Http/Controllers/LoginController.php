<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth2.login');
    }
    
    public function authenticate(AuthRequest $request)
    {
        $credentials = Validator::make($request->all(),[
            'email' => 'required'|'email',
            'password' => 'required',
        ],[
            'email.required' => 'Email is must',
            'email.email' => 'Enter an email address',
            'password.required' => 'Password is must',
        ]
        );

        // try{
        //     if(auth()->guard('admin')->attempt($credentials)){
        //         return MyHelper::resp
        //     }
        // }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken($user->email)->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => $user,
                'message' => $php_errormsg,
            ]);
        }

        return response()->json([
            'message' => 'Invalid login credentials'
        ], 401);
    }
}