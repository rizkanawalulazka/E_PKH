<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        // Ambil data berdasarkan role user
        if (auth()->user()->role === 'admin') {
            // Admin bisa lihat semua data
            $pendaftaran = Pendaftaran::with('user')->latest()->get();
        } else {
            // User biasa hanya bisa lihat data sendiri berdasarkan user_id
            $pendaftaran = Pendaftaran::where('id', auth()->id())->latest()->get();
        }

        return view('pendaftaran.index', compact('pendaftaran'));
    }

    public function create()
    {
        return view('pendaftaran.create');
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nik' => 'required|string|max:16',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:13',
            'komponen' => 'required|array',
            'kartu_keluarga' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            // Handle file upload
            $kartuKeluargaPath = null;
            if ($request->hasFile('kartu_keluarga')) {
                $kartuKeluargaPath = $request->file('kartu_keluarga')->store('kartu_keluarga', 'public');
            }

            // Simpan data ke database
            $pendaftaran = new Pendaftaran();
            $pendaftaran->nik = $request->nik;
            $pendaftaran->nama = $request->nama;
            $pendaftaran->tempat_lahir = $request->tempat_lahir;
            $pendaftaran->tanggal_lahir = $request->tanggal_lahir;
            $pendaftaran->alamat = $request->alamat;
            $pendaftaran->no_hp = $request->no_hp;
            $pendaftaran->komponen = $request->komponen;
            $pendaftaran->kartu_keluarga = $kartuKeluargaPath;
            $pendaftaran->status = 'pending';
            $pendaftaran->save();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil dikirim dan sedang diproses.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Tambahkan method untuk admin menerima/menolak pendaftaran
    public function approve($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->status = 'approved';
        $pendaftaran->save();
        return redirect()->back()->with('success', 'Pendaftaran berhasil disetujui.');
    }

    public function reject($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->status = 'rejected';
        $pendaftaran->save();
        return redirect()->back()->with('success', 'Pendaftaran berhasil ditolak.');
    }
}