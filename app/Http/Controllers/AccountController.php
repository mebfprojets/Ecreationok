<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User; 
use Mail; 
use Hash;

class AccountController extends Controller
{
    public function showResetPasswordForm($token) { 
        return view('auth.forgetPasswordLink', ['token' => $token]);
     }
     public function showForgetPasswordForm($token){
        return view('auth.reset-password', ['token' => $token]);
     }
    public function validatePasswordRequest (Request $request){
        $user = DB::table('users')->where('email', '=', $request->email)
    ->first();//Check if the user exists
    //dd($user);
if (!$user) {
    return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
}
$token= Str::random(60);
//Create Password Reset Token
ResetPassword::create([
    'email' => $request->email,
    'token' => $token,
    'created_at' => date('d-m-Y H:i:s')
]);//Get the token just created above
  

Mail::send('auth.forgetPassword', ['token' => $token], function($message) use($request){

    $message->to($request->email);

    $message->subject('Reset Password');

});



return back()->with('message', 'We have e-mailed your password reset link!');
    }
public function resetPassword(Request $request)
{
    $request->validate([

        'email' => 'required|email|exists:users',

        'password' => 'required|string|min:6|confirmed',

        'password_confirmation' => 'required'

    ]);

//dd($request->all());

    $updatePassword = DB::table('password_resets')

                        ->where([

                          'email' => $request->email, 

                          'token' => $request->token

                        ])

                        ->first();



    if(!$updatePassword){

        return back()->withInput()->with('error', 'Invalid token!');

    }



    $user = User::where('email', $request->email)

                ->update(['password' => Hash::make($request->password)]);



    DB::table('password_resets')->where(['email'=> $request->email])->delete();


    return redirect()->route('index');

}
public function getlogin(){
    return redirect()->route('index');
}


}
