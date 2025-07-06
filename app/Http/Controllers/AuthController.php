<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
            'role' => 'required|in:admin,pendamping,penerima',
            'identifier' => 'required|string',
            'password' => 'required|string',
        ], [
            'role.required' => 'Role wajib dipilih.',
            'identifier.required' => 'NIK/NIP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = [];
        
        // Tentukan field login berdasarkan role
        if ($request->role === 'penerima') {
            // Penerima login dengan NIK
            $credentials = [
                'nik' => $request->identifier,
                'password' => $request->password,
                'role' => 'penerima'
            ];
        } else {
            // Admin dan Pendamping login dengan NIP
            $credentials = [
                'nip' => $request->identifier,
                'password' => $request->password,
                'role' => $request->role
            ];
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('/dashboard');
                case 'pendamping':
                    return redirect()->intended('/dashboard');
                case 'penerima':
                    return redirect()->intended('/dashboard');
                default:
                    return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors([
            'identifier' => 'Kredensial tidak valid.',
        ])->withInput($request->only('role', 'identifier'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|min:16|max:16|unique:users,nik',
            'password' => 'required|string|min:6|confirmed',
            'nama_lengkap' => 'required|string|max:255',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.min' => 'NIK harus 16 digit.',
            'nik.max' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        ]);

        // Default role sebagai penerima
        $user = User::create([
            'nik' => $request->nik,
            'nip' => null, // Penerima tidak memiliki NIP
            'name' => $request->nama_lengkap,
            'password' => Hash::make($request->password),
            'role' => 'penerima'
        ]);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Silakan login untuk mendaftar PKH.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}