<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
            'username' => 'required|string|unique:users,username|min:4|max:255',
            'nomor_telp' => 'required|string|max:15|min:10',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah terdaftar. Silakan gunakan yang lain.',
            'nomor_telp.required' => 'Nomor Telepon wajib diisi.',
            'nomor_telp.max' => 'Nomor Telepon maksimal 15 karakter.',
            'nomor_telp.min' => 'Nomor Telepon minimal 10 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $customerRoleId = 3;
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'nomor_telp' => $request->nomor_telp,
            'password' => $request->password,
            'id_role' => $customerRoleId,
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        return redirect('/')->with('success', 'Pendaftaran berhasil! Selamat datang, ' . $user->name);
    }
}
