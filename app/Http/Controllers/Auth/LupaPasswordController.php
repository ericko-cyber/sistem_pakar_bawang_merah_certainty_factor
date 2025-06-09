<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;



class LupaPasswordController extends Controller
{
    // Menampilkan form input email untuk lupa password
    public function showInputEmail()
    {
        if (Auth::check()) {
            return redirect('/home'); // Ganti dengan redirect ke /dashboard jika diperlukan
        }
        return view('layouts.inputemail');
    }

    // Menampilkan form OTP
    public function showOtpForm()
    {
        if (Auth::check()) {
            return redirect('/home'); // Ganti dengan redirect ke /dashboard jika diperlukan
        }
        return view('layouts.otp');
    }

    // Menampilkan form reset password
    public function showResetPass()
    {
        if (Auth::check()) {
            return redirect('/home'); // Ganti dengan redirect ke /dashboard jika diperlukan
        }
        return view('layouts.resetpass');
    }

    // Mengirimkan OTP ke email pengguna
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:accounts,email',
        ]);

        $otp = rand(100000, 999999);

        // Simpan OTP ke database
        $account = Account::where('email', $request->email)->first();
        $account->otp_code = $otp;
        $account->otp_expires_at = Carbon::now()->addMinutes(10);
        $account->save();

        try {
            // Kirim OTP ke email
            Mail::raw("Kode OTP Anda adalah: $otp. OTP ini berlaku selama 10 menit.", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Reset Password OTP');
            });
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email. Silakan coba lagi.']);
        }

        return redirect()->route('otp.form')->with('email', $request->email);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required',
        ]);

        // Cari akun berdasarkan email dan kode OTP yang valid
        $account = Account::where('email', $request->email)
            ->where('otp_code', $request->otp_code)
            ->where('otp_expires_at', '>', Carbon::now())
            ->first();

        // Log untuk debugging
        Log::debug('Verifikasi OTP: ', [
            'email' => $request->email,
            'otp_code' => $request->otp_code,
            'otp_expires_at' => $account ? $account->otp_expires_at : 'null',
            'found_account' => $account ? 'true' : 'false',
        ]);

        if (!$account) {
            return back()->withErrors(['otp_code' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
        }

        // OTP valid, simpan email di session dan arahkan ke form reset password
        session(['email' => $request->email]);

        return redirect()->route('reset.password.form');
    }



    // Reset password
    public function resetPassword(Request $request)
    {
        Log::debug('Reset Password Request:', $request->all());

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $account = Account::where('email', $request->email)->firstOrFail();

        $account->password = Hash::make($request->password);
        $account->otp_code = null;
        $account->otp_expires_at = null;
        $account->save();

        return redirect()->route('login')->with('success', 'Password berhasil direset.');
    }
}
