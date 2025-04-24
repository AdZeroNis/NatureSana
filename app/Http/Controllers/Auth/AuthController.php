<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showVerificationForm()
    {
        return view('Auth.verify-code');
    }

    public function verifyCode(Request $request)
    {
        $user = auth()->user();
        $submittedCode = $request->code;

        if ((string)$user->verification_code !== (string)$submittedCode) {
            return back()->with('error', 'کد وارد شده صحیح نیست');
        }

        if (now()->gt($user->verification_code_expires_at)) {
            return back()->with('error', 'کد منقضی شده است. لطفاً کد جدید درخواست کنید');
        }

        $user->is_verified = true;
        $user->verification_code = null;
        $user->verification_code_expires_at = null;
        $user->save();

        return redirect()->route('home')->with('success', 'حساب کاربری شما با موفقیت تایید شد');
    }

    public function resendCode(Request $request)
    {
        $user = auth()->user();
        $code = sprintf('%04d', random_int(0, 9999));
        
        $user->verification_code = $code;
        $user->verification_code_expires_at = now()->addMinutes(10);
        $user->save();

        Mail::raw("کد تایید جدید شما: {$code}\n\nاین کد تا 10 دقیقه معتبر است.", function($message) use ($user) {
            $message->to($user->email)
                ->subject('کد تایید سایت گیاهان دارویی');
        });

        return back()->with('success', 'کد جدید به ایمیل شما ارسال شد');
    }
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
            
            // Generate and send verification code
            $code = sprintf('%04d', random_int(0, 9999));
            $user->verification_code = $code;
            $user->verification_code_expires_at = now()->addMinutes(10);
            $user->save();

            // Send email with code
            Mail::raw("کد تایید شما: {$code}\n\nاین کد تا 10 دقیقه معتبر است.", function($message) use ($user) {
                $message->to($user->email)
                    ->subject('کد تایید سایت گیاهان دارویی');
            });

            return redirect()->route('verification.notice')->with('success', 'کد تایید به ایمیل شما ارسال شد');
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
               // Generate and send verification code
            $code = sprintf('%04d', random_int(0, 9999));
            $user->verification_code = $code;
            $user->verification_code_expires_at = now()->addMinutes(10);
            $user->save();

            // Send email with code
            Mail::raw("کد تایید شما: {$code}\n\nاین کد تا 10 دقیقه معتبر است.", function($message) use ($user) {
                $message->to($user->email)
                    ->subject('کد تایید سایت گیاهان دارویی');
            });

            return redirect()->route('verification.notice')->with('success', 'کد تایید به ایمیل شما ارسال شد');
        }
        } else {
            return redirect()->route("login")->with('error', "ایمیل یا رمز غلط است");
        }
    }
}