<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Auth.auth');
    }
    public function showRegisterForm()
    {
        return view('Auth.auth');
    }
    public function register(Request $request){

        $request->validate([
            "name" => "required",
            "email" => "required",
            "phone" => "required",
            "address" => "required",
            "password" => "required|min:6|confirmed",
            "password_confirmation" => "required",
        ]);

        $emailUser = User::where("email", $request->email)->first();
        if ($emailUser == null) {
            $dataForm = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'password' => Hash::make($request->password),
                'role' => 'user',
                'status' => 1
            ];

            $user = User::create($dataForm);
            Auth::login($user);
            $user->sendEmailVerificationNotification();
            
            return redirect()->route('verification.notice')->with('success', 'لطفاً ایمیل خود را تایید کنید');
        } else {
            return redirect()->route("register.form")->with('error', "ایمیل از قبل وجود دارد");
        }
    }
    public function login(Request $request){

        $request->validate([
            "email" => "required",
            "password" => "required",
        ]);

        $user = User::where("email", $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            if ($user->hasVerifiedEmail()) {
                Auth::login($user);
                return redirect()->route("home");
            } else {
                Auth::login($user);
                return redirect()->route('verification.notice')
                    ->with('error', 'لطفاً ایمیل خود را تایید کنید');
            }
        } else {
            return redirect()->route("login")->with('error', "ایمیل یا رمز غلط است");
        }
    }
}
