<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserAddress;
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
            "password" => "required|min:6",
  
        ]);

        $emailUser = User::where("email", $request->email)->first();
        if ($emailUser == null) {
            $dataForm = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
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
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required",
        ]);
    
        $user = User::where("email", $request->email)->first();
    
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route("home");
        } else {
            return redirect()->route("login")->with('error', "ایمیل یا رمز عبور اشتباه است");
        }
    }
    
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("home");
    }
    public function profile(){
        $user = auth()->user();
        return view("Auth.profile", compact('user'));
    }
    public function edit(){
        $user = auth()->user();
        return view("Auth.edit", compact('user'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required',
            'address_one' => 'nullable|string|max:255',
            'address_two' => 'nullable|string|max:255',
            'address_three' => 'nullable|string|max:255',
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
    
        $user->address()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'address_one' => $request->address_one,
                'address_two' => $request->address_two,
                'address_three' => $request->address_three,
            ]
        );

        return redirect()->back()
            ->with('success', 'پروفایل با موفقیت به‌روزرسانی شد');


    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'رمز فعلی صحیح نیست');
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()
            ->with('success', 'رمز عبور با موفقیت به‌روزرسانی شد');
    }
}