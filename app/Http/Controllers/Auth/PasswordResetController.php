<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function showRequestForm()
    {
        return view('Auth.password.request');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'ایمیل وارد شده در سیستم یافت نشد.']);
        }

        // Generate random 4-digit code
        $code = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
            'created_at' => now()
        ]);

        // Send email with code
        Mail::send('Auth.emails.reset-password', ['code' => $code], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('کد بازیابی رمز عبور');
        });

        return redirect()->route('password.verify', ['email' => $request->email, 'token' => $token])
                         ->with('status', 'کد تایید به ایمیل شما ارسال شد.');
    }

    public function showVerifyForm(Request $request)
    {
        return view('Auth.password.verify', [
            'email' => $request->email,
            'token' => $request->token
        ]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'code' => 'required|string|size:4'
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->where('code', $request->code)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$reset) {
            return back()->withErrors(['code' => 'کد وارد شده نامعتبر است یا منقضی شده است.']);
        }

        return redirect()->route('password.reset', [
            'email' => $request->email,
            'token' => $request->token
        ]);
    }

    public function showResetForm(Request $request)
    {
        return view('Auth.password.reset', [
            'email' => $request->email,
            'token' => $request->token
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'درخواست بازیابی رمز عبور نامعتبر است.']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'کاربر یافت نشد.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->update(['is_used' => true]);

        return redirect()->route('login')
                         ->with('status', 'رمز عبور شما با موفقیت تغییر کرد.');
    }
}
