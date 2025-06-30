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
            $pendaftaran = Pendaftaran::where('user_id', auth()->id())->latest()->get();
        }

        return view('pendaftaran.index', compact('pendaftaran'));
    }

    public function create()
    {
        return view('pendaftaran.create');
    }

    public function store(Request $request)
    {
        // Debug: Log request data
        \Log::info('Pendaftaran Request Data:', [
            'user_id' => auth()->id(),
            'nik' => $request->nik,
            'nik_length' => strlen($request->nik ?? ''),
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => substr($request->alamat ?? '', 0, 50) . '...',
            'no_hp' => $request->no_hp,
            'komponen' => $request->komponen,
            'has_file' => $request->hasFile('kartu_keluarga')
        ]);

        // Validasi data
        try {
            $validatedData = $request->validate([
                'nik' => 'required|string|size:16|unique:pendaftaran,nik',
                'nama' => 'required|string|max:255',
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date|before:today',
                'alamat' => 'required|string|min:10',
                'no_hp' => 'required|string|min:10|max:15',
                'komponen' => 'required|array|min:1',
                'komponen.*' => 'in:kesehatan,pendidikan,kesejahteraan_sosial',
                'kartu_keluarga' => 'required|file|image|mimes:jpeg,png,jpg|max:2048'
            ], [
                'nik.required' => 'NIK wajib diisi',
                'nik.size' => 'NIK harus tepat 16 digit',
                'nik.unique' => 'NIK sudah terdaftar sebelumnya',
                'nama.required' => 'Nama lengkap wajib diisi',
                'tempat_lahir.required' => 'Tempat lahir wajib diisi',
                'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
                'tanggal_lahir.before' => 'Tanggal lahir tidak valid',
                'alamat.required' => 'Alamat lengkap wajib diisi',
                'alamat.min' => 'Alamat terlalu pendek',
                'no_hp.required' => 'Nomor HP wajib diisi',
                'no_hp.min' => 'Nomor HP minimal 10 digit',
                'no_hp.max' => 'Nomor HP maksimal 15 digit',
                'komponen.required' => 'Pilih minimal satu komponen bantuan',
                'komponen.min' => 'Pilih minimal satu komponen bantuan',
                'kartu_keluarga.required' => 'Kartu keluarga wajib diunggah',
                'kartu_keluarga.image' => 'File harus berupa gambar',
                'kartu_keluarga.mimes' => 'Format file harus JPG, JPEG, atau PNG',
                'kartu_keluarga.max' => 'Ukuran file maksimal 2MB'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error:', [
                'errors' => $e->errors(),
                'request_data' => $request->except(['kartu_keluarga'])
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        }

        try {
            // Cek apakah user sudah pernah mendaftar
            $existingRegistration = Pendaftaran::where('user_id', auth()->id())->first();
            if ($existingRegistration) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah pernah mendaftar. Silakan cek status pendaftaran Anda.'
                ], 422);
            }

            // Handle file upload
            $kartuKeluargaPath = null;
            if ($request->hasFile('kartu_keluarga')) {
                $file = $request->file('kartu_keluarga');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $kartuKeluargaPath = $file->storeAs('kartu_keluarga', $fileName, 'public');
            }

            // Simpan data ke database menggunakan fillable
            $pendaftaran = Pendaftaran::create([
                'user_id' => auth()->id(),
                'nik' => $validatedData['nik'],
                'nama' => $validatedData['nama'],
                'tempat_lahir' => $validatedData['tempat_lahir'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
                'alamat' => $validatedData['alamat'],
                'no_hp' => $validatedData['no_hp'],
                'komponen' => $validatedData['komponen'],
                'kartu_keluarga' => $kartuKeluargaPath,
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil dikirim dan sedang diproses.',
                'data' => [
                    'id' => $pendaftaran->id,
                    'status' => $pendaftaran->status
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Pendaftaran Error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'request_data' => $request->except(['kartu_keluarga']),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.'
            ], 500);
        }
    }

    // Tambahkan method untuk admin menerima/menolak pendaftaran
    public function approve($id)
    {
        try {
            $pendaftaran = \App\Models\Pendaftaran::findOrFail($id);
            
            // Update status ke approved
            $pendaftaran->status = 'approved';
            $pendaftaran->approved_at = now();
            
            // Auto-assign pendamping jika belum ada
            if (!$pendaftaran->pendamping_id) {
                $pendamping = $this->assignPendamping();
                if ($pendamping) {
                    $pendaftaran->pendamping_id = $pendamping->id;
                }
            }
            
            $pendaftaran->save();
           return redirect()->back()->with('success', 'Pendaftaran berhasil disetujui.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reject($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->status = 'rejected';
        $pendaftaran->save();
        return redirect()->back()->with('success', 'Pendaftaran berhasil ditolak.');
    }

    /**
     * Assign pendamping berdasarkan load balancing
     * Mengambil pendamping dengan jumlah penerima paling sedikit
     */
    private function assignPendamping()
    {
        try {
            // Cari pendamping dengan jumlah penerima yang sudah approved paling sedikit
            $pendamping = \App\Models\Pendamping::withCount(['pendaftaran' => function($query) {
                            $query->where('status', 'approved');
                        }])
                        ->orderBy('pendaftaran_count', 'asc') // Yang paling sedikit penerima
                        ->orderBy('id', 'asc') // Tie-breaker untuk konsistensi
                        ->first();
            
            return $pendamping;
        } catch (\Exception $e) {
            // Fallback: ambil pendamping pertama jika terjadi error
            return \App\Models\Pendamping::first();
        }
    }
}