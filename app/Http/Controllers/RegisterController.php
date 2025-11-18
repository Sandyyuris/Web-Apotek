<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // <-- Wajib: untuk hashing, meskipun Laravel 12+ sudah otomatis
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|min:4|max:255', // Validasi unik
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah terdaftar. Silakan gunakan yang lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $customerRoleId = 3;

        // 3. Buat User Baru
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            // Password sudah di-hash secara otomatis di model User menggunakan mutator:
            // protected function casts(): array { return ['password' => 'hashed', ...]; }
            'password' => $request->password,
            'id_role' => $customerRoleId, // Set role sebagai Customer
        ]);

        // 4. Login Otomatis (Opsional, tapi umum dilakukan setelah register)
        Auth::login($user);
        $request->session()->regenerate();

        // 5. Redirect ke Halaman Utama
        return redirect('/')->with('success', 'Pendaftaran berhasil! Selamat datang, ' . $user->name);
    }
}
