<?php
// filepath: c:\xampp\htdocs\E_PKH\app\Http\Controllers\AdminController.php

namespace App\Http\Controllers;

use App\Models\Pendamping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // ...existing methods...

    /**
     * Menampilkan daftar pendamping untuk admin
     */
    public function daftarPendamping()
    {
        $pendampings = Pendamping::with('user')->get();
        
        return view('pendamping.daftar-pendamping', compact('pendampings'));
    }

    /**
     * Menampilkan form tambah pendamping
     */
    public function createPendamping()
    {
        return view('admin.pendamping.create');
    }

    /**
     * Menyimpan pendamping baru
     */
    public function storePendamping(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:users,nik',
            'email' => 'required|string|email|max:255|unique:users,email',
            'no_hp' => 'required|string|max:20',
            'wilayah_kerja' => 'required|string|max:255',
            'alamat' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        DB::beginTransaction();

        try {
            // Buat user baru
            $user = User::create([
                'name' => $request->nama_lengkap,
                'nik' => $request->nik,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pendamping',
            ]);

            // Buat profil pendamping
            Pendamping::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'no_hp' => $request->no_hp,
                'wilayah_kerja' => $request->wilayah_kerja,
                'alamat' => $request->alamat,
                'status' => 'aktif',
            ]);

            DB::commit();

            return redirect()->route('admin.pendamping')
                ->with('success', 'Pendamping berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal menambahkan pendamping: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan data pendamping untuk edit
     */
    public function editPendamping($id)
    {
        $pendamping = Pendamping::with('user')->findOrFail($id);
        
        return response()->json([
            'id' => $pendamping->id,
            'nama_lengkap' => $pendamping->nama_lengkap,
            'no_hp' => $pendamping->no_hp,
            'wilayah_kerja' => $pendamping->wilayah_kerja,
            'alamat' => $pendamping->alamat,
            'status' => $pendamping->status,
            'user' => [
                'nik' => $pendamping->user->nik,
                'email' => $pendamping->user->email,
            ]
        ]);
    }

    /**
     * Update data pendamping
     */
    public function updatePendamping(Request $request, $id)
    {
        $pendamping = Pendamping::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:users,nik,' . $pendamping->user_id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $pendamping->user_id,
            'no_hp' => 'required|string|max:20',
            'wilayah_kerja' => 'required|string|max:255',
            'alamat' => 'required|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        DB::beginTransaction();

        try {
            // Update user
            $pendamping->user->update([
                'name' => $request->nama_lengkap,
                'nik' => $request->nik,
                'email' => $request->email,
            ]);

            // Update pendamping
            $pendamping->update([
                'nama_lengkap' => $request->nama_lengkap,
                'no_hp' => $request->no_hp,
                'wilayah_kerja' => $request->wilayah_kerja,
                'alamat' => $request->alamat,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.pendamping')
                ->with('success', 'Data pendamping berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal mengupdate data pendamping: ' . $e->getMessage());
        }
    }

    /**
     * Hapus pendamping
     */
    public function destroyPendamping($id)
    {
        $pendamping = Pendamping::findOrFail($id);

        DB::beginTransaction();

        try {
            // Hapus pendamping
            $pendamping->delete();
            
            // Hapus user
            $pendamping->user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pendamping berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus pendamping: ' . $e->getMessage()
            ]);
        }
    }
}