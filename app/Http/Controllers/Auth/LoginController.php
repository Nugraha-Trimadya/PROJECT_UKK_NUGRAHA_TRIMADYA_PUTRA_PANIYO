<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

    // Trait bawaan Laravel untuk menangani proses login, logout, dan validasi dasar autentikasi.
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // Setelah login berhasil, user akan diarahkan ke halaman ini.
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Hanya user tamu yang boleh akses halaman login. User yang sudah login tidak perlu kembali ke sini.
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request): void
    {
        // Validasi input login sebelum proses autentikasi dijalankan.
        $request->validate([
            $this->username() => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            // Pesan error yang lebih mudah dipahami user.
            'email.required' => 'email harus diisi',
            'email.email' => 'format email tidak valid',
            'password.required' => 'password harus diisi',
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        // Jika email atau password salah, tampilkan pesan umum tanpa membocorkan data mana yang salah.
        throw ValidationException::withMessages([
            $this->username() => ['email atau password salah'],
        ]);
    }
}
