<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranPKHController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $pendaftaran = Pendaftaran::latest()->get();
        } else {
            $pendaftaran = Pendaftaran::where('nik', $user->nik)->latest()->get();
        }
        return view('pendaftaran.index', compact('pendaftaran'));
    }

    public function create()
    {
        return view('pendaftaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16|unique:pendaftaran,nik',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:13',
            'komponen' => 'required|array',
            'komponen.*' => 'required|string|in:kesehatan,pendidikan,kesejahteraan_sosial',
            'kartu_keluarga' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'nama.required' => 'Nama lengkap wajib diisi',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid',
            'alamat.required' => 'Alamat wajib diisi',
            'no_hp.required' => 'Nomor HP wajib diisi',
            'no_hp.max' => 'Nomor HP maksimal 13 digit',
            'komponen.required' => 'Pilih minimal satu komponen bantuan',
            'kartu_keluarga.required' => 'Gambar kartu keluarga wajib diunggah',
            'kartu_keluarga.image' => 'File harus berupa gambar',
            'kartu_keluarga.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',
            'kartu_keluarga.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        try {
            // Proses upload file kartu keluarga
            $kartuKeluargaPath = null;
            if ($request->hasFile('kartu_keluarga')) {
                $kartuKeluargaPath = $request->file('kartu_keluarga')->store('kartu_keluarga', 'public');
            }

            $pendaftaran = Pendaftaran::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'komponen' => $request->komponen,
                'status' => 'pending',
                'additional_data' => json_encode([
                    'kartu_keluarga' => $kartuKeluargaPath
                ])
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran PKH berhasil dikirim dan sedang dalam proses verifikasi.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
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