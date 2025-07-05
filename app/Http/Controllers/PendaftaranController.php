<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Pendamping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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
            'has_kartu_keluarga' => $request->hasFile('kartu_keluarga'),
            'has_foto_rumah' => $request->hasFile('foto_rumah') // Tambahkan ini
        ]);

        // Validasi data
        try {
            $validatedData = $request->validate([
                'nik' => 'required|string|size:16|unique:pendaftaran,nik',
                'no_kk' => 'required|digits:16',
                'nama' => 'required|string|max:255',
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date|before:today',
                'alamat' => 'required|string|min:10',
                'no_hp' => 'required|string|min:10|max:15',
                'komponen' => 'required|array|min:1',
                'komponen.*' => 'in:ibu_hamil,balita,lansia,anak_sd,anak_smp,anak_sma,disabilitas_berat,lanjut_usia',
                'kartu_keluarga' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
                'foto_rumah' => 'required|file|image|mimes:jpeg,png,jpg|max:2048', // Pastikan validation lengkap
            ], [
                'nik.required' => 'NIK wajib diisi',
                'nik.size' => 'NIK harus tepat 16 digit',
                'nik.unique' => 'NIK sudah terdaftar sebelumnya',
                'no_kk.required' => 'No. Kartu Keluarga wajib diisi',
                'no_kk.digits' => 'No. Kartu Keluarga harus 16 digit',
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
                'kartu_keluarga.file' => 'Kartu keluarga harus berupa file',
                'kartu_keluarga.image' => 'Kartu keluarga harus berupa gambar',
                'kartu_keluarga.mimes' => 'Format kartu keluarga harus JPG, JPEG, atau PNG',
                'kartu_keluarga.max' => 'Ukuran kartu keluarga maksimal 2MB',
                'foto_rumah.required' => 'Foto rumah wajib diunggah',
                'foto_rumah.file' => 'Foto rumah harus berupa file',
                'foto_rumah.image' => 'Foto rumah harus berupa gambar',
                'foto_rumah.mimes' => 'Format foto rumah harus JPG, JPEG, atau PNG',
                'foto_rumah.max' => 'Ukuran foto rumah maksimal 2MB',
                'komponen.*' => 'Pilihan komponen bantuan tidak valid',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error:', [
                'errors' => $e->errors(),
                'request_data' => $request->except(['kartu_keluarga', 'foto_rumah'])
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

            // PERBAIKAN: Handle file upload untuk kedua file
            $kartuKeluargaPath = null;
            $fotoRumahPath = null;

            // Upload Kartu Keluarga
            if ($request->hasFile('kartu_keluarga')) {
                $file = $request->file('kartu_keluarga');
                $fileName = time() . '_kk_' . $file->getClientOriginalName();
                $kartuKeluargaPath = $file->storeAs('kartu_keluarga', $fileName, 'public');
            }

            // Upload Foto Rumah
            if ($request->hasFile('foto_rumah')) {
                $file = $request->file('foto_rumah');
                $fileName = time() . '_rumah_' . $file->getClientOriginalName();
                $fotoRumahPath = $file->storeAs('foto_rumah', $fileName, 'public');
            }

            // Simpan data ke database dengan semua field
            $pendaftaran = Pendaftaran::create([
                'user_id' => auth()->id(),
                'nik' => $validatedData['nik'],
                'no_kk' => $validatedData['no_kk'], // Gunakan validated data
                'nama' => $validatedData['nama'],
                'tempat_lahir' => $validatedData['tempat_lahir'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
                'alamat' => $validatedData['alamat'],
                'no_hp' => $validatedData['no_hp'],
                'komponen' => implode(', ', $validatedData['komponen']), // Convert array to JSON
                'kartu_keluarga' => $kartuKeluargaPath,
                'foto_rumah' => $fotoRumahPath, // Sekarang sudah didefinisikan
                'status' => 'pending'
            ]);

            \Log::info('Pendaftaran berhasil disimpan:', [
                'id' => $pendaftaran->id,
                'user_id' => $pendaftaran->user_id,
                'nik' => $pendaftaran->nik,
                'kartu_keluarga_path' => $kartuKeluargaPath,
                'foto_rumah_path' => $fotoRumahPath
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil dikirim dan sedang diproses.',
                'data' => [
                    'id' => $pendaftaran->id,
                    'status' => $pendaftaran->status,
                    'files_uploaded' => [
                        'kartu_keluarga' => $kartuKeluargaPath ? true : false,
                        'foto_rumah' => $fotoRumahPath ? true : false
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Pendaftaran Error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'request_data' => $request->except(['kartu_keluarga', 'foto_rumah']),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.',
                'error' => $e->getMessage() // Hapus ini di production
            ], 500);
        }
    }

    // Tambahkan method untuk admin menerima/menolak pendaftaran
    public function approve($id)
    {
        try {
            $user = auth()->user();

            // Pastikan hanya admin yang bisa approve
            if ($user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Hanya admin yang bisa menyetujui pendaftaran.'
                ], 403);
            }

            $pendaftaran = \App\Models\Pendaftaran::findOrFail($id);

            // Cek apakah status masih pending
            if ($pendaftaran->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran sudah diproses sebelumnya. Status saat ini: ' . $pendaftaran->status
                ], 400);
            }

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

            // Log aktivitas
            \Log::info('Pendaftaran approved', [
                'id' => $id,
                'admin' => $user->name,
                'pendamping_assigned' => $pendaftaran->pendamping_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil disetujui.',
                'data' => [
                    'id' => $pendaftaran->id,
                    'status' => $pendaftaran->status,
                    'pendamping_id' => $pendaftaran->pendamping_id
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error approving pendaftaran', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reject($id)
    {
        try {
            $user = auth()->user();

            // Pastikan hanya admin yang bisa reject
            if ($user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Hanya admin yang bisa menolak pendaftaran.'
                ], 403);
            }

            $pendaftaran = \App\Models\Pendaftaran::findOrFail($id);

            // Cek apakah status masih pending
            if ($pendaftaran->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran sudah diproses sebelumnya. Status saat ini: ' . $pendaftaran->status
                ], 400);
            }

            // Update status ke rejected
            $pendaftaran->status = 'rejected';
            $pendaftaran->approved_at = null; // Reset approved_at
            $pendaftaran->pendamping_id = null; // Reset pendamping jika ada
            $pendaftaran->save();

            // Log aktivitas
            \Log::info('Pendaftaran rejected', [
                'id' => $id,
                'admin' => $user->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil ditolak.',
                'data' => [
                    'id' => $pendaftaran->id,
                    'status' => $pendaftaran->status
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error rejecting pendaftaran', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Assign pendamping berdasarkan load balancing
     * Mengambil pendamping dengan jumlah penerima paling sedikit
     */


    public function assignPendampingManual($id)
    {
        try {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak.'
                ], 403);
            }

            $pendaftaran = Pendaftaran::findOrFail($id);

            if ($pendaftaran->status !== 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran harus disetujui terlebih dahulu.'
                ], 400);
            }

            if ($pendaftaran->pendamping_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendamping sudah ditugaskan.'
                ], 400);
            }

            $pendamping = $this->assignPendamping();

            if (!$pendamping) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada pendamping yang tersedia.'
                ], 400);
            }

            $pendaftaran->pendamping_id = $pendamping->id;
            $pendaftaran->save();

            // Load relasi untuk response
            $pendamping->load('user');

            Log::info('Pendamping ditugaskan manual', [
                'pendaftaran_id' => $id,
                'pendamping_id' => $pendamping->id,
                'admin' => $user->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pendamping berhasil ditugaskan',
                'data' => [
                    'pendamping_name' => $pendamping->user->name,
                    'pendamping_id' => $pendamping->id,
                    'pendamping_wilayah' => $pendamping->wilayah_kerja
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error assigning pendamping manually', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

     private function assignPendamping()
    {
        try {
            // PERBAIKAN: Gunakan relasi yang benar
            $pendamping = Pendamping::withCount([
                'pendaftaran as approved_count' => function ($query) {
                    $query->where('status', 'approved');
                }
            ])
                ->where('status', 'aktif')
                ->orderBy('approved_count', 'asc')
                ->orderBy('id', 'asc')
                ->first();

            // Debug log
            Log::info('Assigning pendamping', [
                'pendamping_found' => $pendamping ? true : false,
                'pendamping_id' => $pendamping ? $pendamping->id : null,
                'approved_count' => $pendamping ? $pendamping->approved_count : 0
            ]);

            return $pendamping;
        } catch (\Exception $e) {
            Log::error('Error assigning pendamping', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Fallback: ambil pendamping aktif pertama
            return Pendamping::where('status', 'active')->first();
        }
    }

    // Tambahkan method ini
    public function updateStatusPendaftaran(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,approved,rejected',
            ]);

            $pendaftaran = \App\Models\Pendaftaran::findOrFail($id);
            $oldStatus = $pendaftaran->status;

            // Update status
            $pendaftaran->status = $request->status;

            // Hanya set approved_at, HAPUS bagian rejected_at
            if ($request->status == 'approved') {
                $pendaftaran->approved_at = now();
            } else {
                // Reset approved_at jika status bukan approved
                $pendaftaran->approved_at = null;
            }

            $pendaftaran->save();

            // Log aktivitas
            \Log::info('Status pendaftaran diubah', [
                'id' => $id,
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'admin' => auth()->user()->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diubah dari ' . $oldStatus . ' menjadi ' . $request->status
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating pendaftaran status', [
                'id' => $id,
                'status' => $request->status,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function updateStatus(Request $request, $id)
    {
        try {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Hanya admin yang bisa mengubah status.'
                ], 403);
            }

            $request->validate([
                'status' => 'required|in:pending,approved,rejected'
            ]);

            $pendaftaran = Pendaftaran::findOrFail($id);
            $originalStatus = $pendaftaran->status;

            // Update status
            $pendaftaran->status = $request->status;

            // OTOMATIS ASSIGN PENDAMPING SAAT STATUS DISETUJUI
            if ($request->status === 'approved') {
                $pendaftaran->approved_at = now();

                // Debug: Cek jumlah pendamping aktif
                $activePendampingCount = Pendamping::where('status', 'active')->count();
                Log::info('Active pendamping count', ['count' => $activePendampingCount]);

                // Assign pendamping
                $pendamping = $this->assignPendamping();

                if ($pendamping) {
                    $pendaftaran->pendamping_id = $pendamping->id;
                    Log::info('Pendamping assigned', [
                        'pendamping_id' => $pendamping->id,
                        'pendamping_name' => $pendamping->user->name ?? 'Unknown'
                    ]);
                } else {
                    Log::warning('No pendamping available for assignment');
                }
            } else {
                // Reset approved_at dan pendamping_id jika status bukan approved
                $pendaftaran->approved_at = null;
                $pendaftaran->pendamping_id = null;
            }

            $pendaftaran->save();

            // Reload pendaftaran dengan relasi untuk response
            $pendaftaran = $pendaftaran->fresh(['pendamping.user']);

            $message = 'Status berhasil diperbarui';
            if ($request->status === 'approved') {
                if ($pendaftaran->pendamping_id) {
                    $message .= ' dan pendamping telah ditugaskan';
                } else {
                    $message .= ' namun tidak ada pendamping yang tersedia';
                }
            }

            Log::info('Status pendaftaran diupdate', [
                'id' => $id,
                'old_status' => $originalStatus,
                'new_status' => $request->status,
                'admin' => $user->name,
                'pendamping_assigned' => $pendaftaran->pendamping_id
            ]);

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'id' => $pendaftaran->id,
                    'status' => $pendaftaran->status,
                    'approved_at' => $pendaftaran->approved_at,
                    'pendamping_id' => $pendaftaran->pendamping_id,
                    'pendamping_name' => $pendaftaran->pendamping ? $pendaftaran->pendamping->user->name : null,
                    'pendamping_wilayah' => $pendaftaran->pendamping ? $pendaftaran->pendamping->wilayah_kerja : null
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating status', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'original_status' => $originalStatus ?? 'pending'
            ], 500);
        }
    }



    public function getDetail($id)
    {
        try {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak.'
                ], 403);
            }

            $pendaftaran = Pendaftaran::with(['user', 'pendamping.user'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $pendaftaran->id,
                    'nik' => $pendaftaran->nik,
                    'nama' => $pendaftaran->nama,
                    'tempat_lahir' => $pendaftaran->tempat_lahir,
                    'tanggal_lahir' => $pendaftaran->tanggal_lahir,
                    'alamat' => $pendaftaran->alamat,
                    'no_hp' => $pendaftaran->no_hp,
                    'komponen' => $pendaftaran->komponen,
                    'status' => $pendaftaran->status,
                    'created_at' => $pendaftaran->created_at,
                    'approved_at' => $pendaftaran->approved_at,
                    'pendamping' => $pendaftaran->pendamping ? [
                        'id' => $pendaftaran->pendamping->id,
                        'name' => $pendaftaran->pendamping->user->name,
                        'wilayah_kerja' => $pendaftaran->pendamping->wilayah_kerja
                    ] : null
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}