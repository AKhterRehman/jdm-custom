<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetOtpController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate(['email' => ['required', 'email', 'max:255']]);
        $email = Str::lower($data['email']);
        $key = 'password-reset-otp:'.$email.'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            throw ValidationException::withMessages(['email' => 'Please wait a minute before requesting another code.']);
        }

        RateLimiter::hit($key, 60);

        if (! User::where('email', $email)->exists()) {
            throw ValidationException::withMessages(['email' => 'We can\'t find a user with that email address.']);
        }

        $code = (string) random_int(100000, 999999);

        PasswordResetOtp::updateOrCreate(['email' => $email], [
            'code_hash' => Hash::make($code),
            'attempts' => 0,
            'expires_at' => now()->addMinutes(10),
            'verified_at' => null,
        ]);

        Mail::to($email)->send(new PasswordResetOtpMail($code));

        $request->session()->put('password_reset_email', $email);
        $request->session()->forget('password_reset_otp_verified');

        return redirect()->route('password.otp')->with('status', 'We sent a 6-digit verification code to your email.');
    }

    public function showOtp(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('password_reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-reset-otp', ['email' => $request->session()->get('password_reset_email')]);
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $email = $request->session()->get('password_reset_email');

        if (! $email) {
            return redirect()->route('password.request');
        }

        $data = $request->validate(['otp' => ['required', 'digits:6']]);
        $otp = PasswordResetOtp::where('email', $email)->first();

        if (! $otp || $otp->expires_at->isPast()) {
            PasswordResetOtp::where('email', $email)->delete();
            return redirect()->route('password.request')->withErrors(['email' => 'This verification code has expired. Please request a new one.']);
        }

        if ($otp->attempts >= 5 || ! Hash::check($data['otp'], $otp->code_hash)) {
            $otp->increment('attempts');
            throw ValidationException::withMessages(['otp' => 'The verification code is invalid. Please try again.']);
        }

        $otp->update(['verified_at' => now()]);
        $request->session()->put('password_reset_otp_verified', true);

        return redirect()->route('password.reset');
    }

    public function showReset(Request $request): View|RedirectResponse
    {
        if (! $request->session()->get('password_reset_email') || ! $request->session()->get('password_reset_otp_verified')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password', ['email' => $request->session()->get('password_reset_email')]);
    }

    public function reset(Request $request): RedirectResponse
    {
        $email = $request->session()->get('password_reset_email');
        $verified = $request->session()->get('password_reset_otp_verified');

        if (! $email || ! $verified) {
            return redirect()->route('password.request');
        }

        $data = $request->validate(['password' => ['required', 'confirmed', 'min:8']]);
        $user = User::where('email', $email)->firstOrFail();
        $user->update(['password' => Hash::make($data['password'])]);

        PasswordResetOtp::where('email', $email)->delete();
        $request->session()->forget(['password_reset_email', 'password_reset_otp_verified']);

        return redirect()->route('login')->with('status', 'Your password has been reset. You can now sign in.');
    }
}
