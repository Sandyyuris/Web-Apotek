<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'min:4', 'max:255', Rule::unique('users', 'username')->ignore($user->id_users, 'id_users')],
            'nomor_telp' => 'required|string|max:15|min:10',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'username.unique' => 'Username ini sudah terdaftar. Silakan gunakan yang lain.',
            'nomor_telp.required' => 'Nomor Telepon wajib diisi.',
            'nomor_telp.max' => 'Nomor Telepon maksimal 15 karakter.',
            'nomor_telp.min' => 'Nomor Telepon minimal 10 karakter.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'nomor_telp' => $request->nomor_telp,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }
        $user->update($data);
        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
    }

    public function riwayatPembelian()
    {
        $histories = Transaksi::with(['detailTransaksis.produk'])
            ->where('id_users', Auth::id())
            ->latest()
            ->paginate(10);
        return view('profile.history', compact('histories'));
    }
}
