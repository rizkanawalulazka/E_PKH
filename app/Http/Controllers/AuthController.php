<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan model User sudah ada
use App\Models\Pendamping;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
       

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required|string',
            'password' => 'required|string',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = [
            'nik' => $request->nik,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        $user = Auth::user();
        
        // SEMUA ROLE DIARAHKAN KE DASHBOARD
        if ($user->role === 'admin') {
            return redirect()->intended('/dashboard');
        } elseif ($user->role === 'pendamping') {
            return redirect()->intended('/dashboard'); // UBAH INI DARI /pendamping KE /dashboard
        } elseif ($user->role === 'penerima' || $user->role === 'user') {
            return redirect()->intended('/dashboard'); // PASTIKAN KE DASHBOARD
        } else {
            return redirect()->intended('/dashboard'); // DEFAULT KE DASHBOARD
        }
    }

        return back()->withErrors([
            'nik' => 'NIK atau password salah.',
        ])->withInput($request->only('nik'));
    }

    public function showRegister()
    {
         
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Cetak semua inputan
    
        $request->validate([
            'nik' => 'required|string|min:16|max:16|unique:users,nik',
            'password' => 'required|string|min:6',
            'role' => 'required|in:pendamping,penerima,admin',
            'nama_lengkap' => 'required|string|max:255',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.min' => 'NIK harus 16 digit.',
            'nik.max' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Pilih tipe akun.',
            'role.in' => 'Tipe akun tidak valid.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        ]);

        $user = User::create([
            'nik' => $request->nik,
            'name' => $request->nama_lengkap,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);
         // Debugging: Cek apakah user berhasil dibuat

        // Jika mendaftar sebagai pendamping, buat data pendamping
        if ($request->role === 'pendamping') {
            Pendamping::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'no_hp' => $request->no_hp ?? '-',
                'alamat' => $request->alamat ?? '-',
                'wilayah_kerja' => $request->wilayah_kerja ?? '-'
            ]);
        }
        
        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}