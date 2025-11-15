<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHKAN INI
use Illuminate\Validation\ValidationException; // <-- TAMBAHKAN INI

class LoginController extends Controller
{
    public function index()
    {
        // Cek apakah user sudah login, jika ya, arahkan ke halaman utama
        if (Auth::check()) {
            return redirect('/');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Kolom Username wajib diisi.',
            'password.required' => 'Kolom Password wajib diisi.',
        ]);

        // 2. Coba autentikasi
        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk mencegah session fixation attack
            $request->session()->regenerate();

            // Redirect ke halaman yang dituju (intended) atau halaman utama
            // Diasumsikan halaman utama adalah '/'
            return redirect()->intended('/');
        }

        // 3. Jika autentikasi gagal, lempar exception dengan pesan error
        throw ValidationException::withMessages([
            'username' => ['Username atau Password yang Anda masukkan tidak valid.'],
        ])->redirectTo(route('login'))->onlyInput('username');
    }

    // Metode Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
