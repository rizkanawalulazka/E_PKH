<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pendamping;
use Illuminate\Http\Request;
use App\Models\LaporanPendampingan;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PendampingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'pendamping') {
            $pendampingProfile = $user->pendamping;

            // Ambil penerima yang didampingi oleh pendamping ini
            $penerima = User::where('role', 'penerima')
                ->whereHas('pendaftaran', function ($query) use ($pendampingProfile) {
                    $query->where('pendamping_id', $pendampingProfile->id)
                        ->where('status', 'approved');
                })
                ->with([
                    'pendaftaran' => function ($query) use ($pendampingProfile) {
                        $query->where('pendamping_id', $pendampingProfile->id)
                            ->where('status', 'approved');
                    }
                ])
                ->get();

            // Tambahkan status laporan untuk setiap penerima
            foreach ($penerima as $p) {
                $latestReport = LaporanPendampingan::where('pendamping_id', $pendampingProfile->id)
                    ->where('penerima_id', $p->id)
                    ->latest('tanggal')
                    ->first();

                $p->report_status = $latestReport ? $latestReport->status : null;
            }

            // Data statistik pendamping
            $totalPenerima = $penerima->count();
            $penerimaSelesai = $penerima->filter(function ($p) {
                return $p->report_status === 'Selesai';
            })->count();
            $penerimaProses = $penerima->filter(function ($p) {
                return $p->report_status === 'Proses';
            })->count();
            $penerimaBelumDidampingi = $penerima->filter(function ($p) {
                return is_null($p->report_status);
            })->count();

        } else {
            // Jika admin, tampilkan semua penerima
            $penerima = User::where('role', 'penerima')->get();
            $totalPenerima = $penerima->count();
            $penerimaSelesai = 0;
            $penerimaProses = 0;
            $penerimaBelumDidampingi = 0;
            $pendampingProfile = null;
        }

        return view('pendamping.index', [
            'penerima' => $penerima,
            'pendampingProfile' => $pendampingProfile,
            'totalPenerima' => $totalPenerima,
            'penerimaSelesai' => $penerimaSelesai,
            'penerimaProses' => $penerimaProses,
            'penerimaBelumDidampingi' => $penerimaBelumDidampingi,
            'title' => 'Dashboard Pendamping',
            'menuPenerima' => 'active'
        ]);
    }
    public function daftarPenerima()
    {
        $user = Auth::user();

        // Jika user adalah penerima, redirect ke dashboard
        if ($user->role === 'penerima') {
            return redirect()->route('dashboard');
        }

        // Jika user adalah pendamping atau admin, tampilkan daftar pendamping
        if ($user->role === 'pendamping' || $user->role === 'admin') {
            $pendampings = Pendamping::with('user')->get();

            return view('pendamping.daftar-pendamping', [
                'pendampings' => $pendampings,
                'title' => 'Daftar Pendamping',
                'menuPendampingList' => 'active',
            ]);
        }

        // Default fallback
        return redirect()->route('');
    }

    public function buatLaporan($penerima_id)
    {
        $penerima = \App\Models\User::findOrFail($penerima_id);
        return view('pendamping.buat-laporan', [
            'penerima' => $penerima,
            'title' => 'Buat Laporan Pendampingan',
            'menuLaporan' => 'active',
        ]);
    }

    public function simpanLaporan(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'penerima_id' => 'required|exists:users,id',
            'kegiatan' => 'required|string',
            'status' => 'required|in:Selesai,Proses',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan_pendampingan', 'public');
        }

        $pendamping = Auth::user()->pendamping;
        LaporanPendampingan::create([
            'pendamping_id' => $pendamping->id,
            'penerima_id' => $request->penerima_id,
            'tanggal' => $request->tanggal,
            'kegiatan' => $request->kegiatan,
            'status' => $request->status,
            'foto' => $fotoPath,
            'verifikasi_status' => 'pending',
        ]);

        return redirect()->route('pendamping.laporan')->with('success', 'Laporan berhasil dikirim dan menunggu verifikasi admin.');
    }

    public function updatePenerimaReportStatus(Request $request, $penerima_id)
    {
        $request->validate([
            'status' => 'required|in:Selesai,Proses',
        ]);

        $user = Auth::user();
        if ($user->role !== 'pendamping') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $pendampingProfile = $user->pendamping;
        if (!$pendampingProfile) {
            return response()->json(['success' => false, 'message' => 'Profil pendamping tidak ditemukan.'], 404);
        }

        $latestReport = LaporanPendampingan::where('pendamping_id', $pendampingProfile->id)
            ->where('penerima_id', $penerima_id)
            ->latest('tanggal')
            ->first();

        if (!$latestReport) {
            return response()->json(['success' => false, 'message' => 'Belum ada laporan untuk penerima ini.'], 404);
        }

        $latestReport->status = $request->status;
        $latestReport->save();

        return response()->json(['success' => true, 'message' => 'Status laporan berhasil diperbarui.', 'new_status' => $request->status]);
    }

    public function daftarLaporan()
    {
        $user = auth()->user();

        if ($user->role !== 'pendamping') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $pendampingProfile = $user->pendamping;

        if (!$pendampingProfile) {
            return redirect()->route('dashboard')->with('error', 'Profil pendamping tidak ditemukan.');
        }

        // Ambil semua pendaftaran yang didampingi
        $pendaftaran = \App\Models\Pendaftaran::where('pendamping_id', $pendampingProfile->id)
            ->where('status', 'approved')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        // PERBAIKAN: Hitung statistik di controller
        $totalPenerima = $pendaftaran->count();
        $penerimaAktif = $pendaftaran->where('status', 'approved')->count();
        
        // Hitung pendaftaran bulan ini
        $pendaftaranBulanIni = \App\Models\Pendaftaran::where('pendamping_id', $pendampingProfile->id)
            ->where('status', 'approved')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('pendamping.daftar-laporan', [
            'title' => 'Daftar Laporan Pendampingan',
            'pendaftaran' => $pendaftaran,
            'pendamping' => $pendampingProfile,
            'user' => $user,
            'totalPenerima' => $totalPenerima,
            'penerimaAktif' => $penerimaAktif,
            'pendaftaranBulanIni' => $pendaftaranBulanIni
        ]);
    }

    public function approveLaporan($id)
    {
        $laporan = \App\Models\LaporanPendampingan::findOrFail($id);
        $laporan->verifikasi_status = 'approved';
        $laporan->catatan_admin = 'Disetujui admin';
        $laporan->save();
        return redirect()->back()->with('success', 'Laporan berhasil disetujui.');
    }

    public function rejectLaporan($id)
    {
        $laporan = \App\Models\LaporanPendampingan::findOrFail($id);
        $laporan->verifikasi_status = 'rejected';
        $laporan->catatan_admin = 'Ditolak admin';
        $laporan->save();
        return redirect()->back()->with('success', 'Laporan berhasil ditolak.');
    }


    public function infoPendamping()
    {
        $user = auth()->user();

        // Pastikan hanya penerima yang bisa mengakses
        if ($user->role !== 'penerima') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Halaman ini hanya untuk penerima PKH.');
        }

        // Cek status pendaftaran berdasarkan user_id
        $pendaftaran = \App\Models\Pendaftaran::where('user_id', $user->id)
            ->where('status', 'approved')
            ->with('pendamping.user') // Eager loading pendamping
            ->latest()
            ->first();

        $pendamping = null;

        if ($pendaftaran) {
            // Ambil pendamping yang sudah ditetapkan dari relasi database
            $pendamping = $pendaftaran->pendamping;

            // Jika belum ada pendamping yang ditetapkan, assign secara otomatis
            if (!$pendamping) {
                $pendamping = $this->assignPendampingToPendaftaran($pendaftaran);

                // Update pendaftaran dengan pendamping yang baru di-assign
                if ($pendamping) {
                    $pendaftaran->pendamping_id = $pendamping->id;
                    $pendaftaran->save();

                    // Refresh relasi
                    $pendaftaran->load('pendamping.user');
                    $pendamping = $pendaftaran->pendamping;
                }
            }
        }

        // Return ke view yang benar dengan data yang diperlukan
        return view('pendamping.info-pendamping', [
            'title' => 'Info Pendamping',
            'pendaftaran' => $pendaftaran,
            'pendamping' => $pendamping,
            'user' => $user
        ]);
    }



    /**
     * Assign pendamping berdasarkan load balancing (pendamping dengan penerima paling sedikit)
     */
    private function assignPendampingToPendaftaran($pendaftaran)
    {
        try {
            // Cari pendamping dengan jumlah penerima paling sedikit
            $pendamping = \App\Models\Pendamping::withCount([
                'pendaftaran' => function ($query) {
                    $query->where('status', 'approved');
                }
            ])
                ->orderBy('pendaftaran_count', 'asc')
                ->orderBy('id', 'asc') // Tie-breaker untuk konsistensi
                ->first();

            return $pendamping;
        } catch (\Exception $e) {
            // Fallback: ambil pendamping pertama jika terjadi error
            return \App\Models\Pendamping::with('user')->first();
        }
    }

    public function store(Request $request)
    {
        // Check role admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Hanya admin yang dapat menambah pendamping'
            ], 403);
        }

        try {
            $validated = $request->validate([
                'nik' => 'required|digits:16|unique:users,nik',
                'name' => 'required|string|max:255',
                'password' => 'required|min:6',
                'no_hp' => 'required|digits_between:10,15',
                'alamat' => 'required|string',
                'wilayah_kerja' => 'required|string'
            ]);

            // Buat user pendamping
            $user = User::create([
                'nik' => $validated['nik'],
                'name' => $validated['name'],
                'password' => Hash::make($validated['password']),
                'role' => 'pendamping'
            ]);

            // Buat data pendamping
            $pendamping = Pendamping::create([
                'user_id' => $user->id,
                'no_hp' => $validated['no_hp'],
                'alamat' => $validated['alamat'],
                'wilayah_kerja' => $validated['wilayah_kerja'],
                'status' => 'active'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pendamping berhasil ditambahkan!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Error creating pendamping:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ], 500);
        }
    }

    public function edit($id)
    {
        // Check role admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            $user = User::with('pendamping')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        // Check role admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'nik' => 'required|digits:16|unique:users,nik,' . $id,
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:6',
            'no_hp' => 'required|digits_between:10,15',
            'alamat' => 'required|string',
            'wilayah_kerja' => 'required|string'
        ]);

        try {
            $user = User::findOrFail($id);

            // Update user data
            $user->update([
                'nik' => $request->nik,
                'name' => $request->name,
            ]);

            // Update password jika diisi
            if ($request->password) {
                $user->update(['password' => Hash::make($request->password)]);
            }

            // Update atau buat data pendamping
            $user->pendamping()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'no_hp' => $request->no_hp,
                    'alamat' => $request->alamat,
                    'wilayah_kerja' => $request->wilayah_kerja,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Data pendamping berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus($id)
    {
        // Check role admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            $user = User::findOrFail($id);
            $pendamping = $user->pendamping;

            if (!$pendamping) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pendamping tidak ditemukan'
                ], 404);
            }

            $newStatus = $pendamping->status === 'active' ? 'inactive' : 'active';
            $pendamping->update(['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => 'Status pendamping berhasil diubah menjadi ' . $newStatus
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        // Check role admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            $user = User::findOrFail($id);

            // Cek apakah pendamping masih memiliki penerima aktif
            if ($user->pendamping) {
                $activePenerima = Pendaftaran::where('pendamping_id', $user->pendamping->id)
                    ->where('status', 'approved')
                    ->count();

                if ($activePenerima > 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak dapat menghapus pendamping yang masih memiliki penerima aktif'
                    ], 400);
                }

                // Hapus data pendamping terlebih dahulu
                $user->pendamping->delete();
            }

            // Hapus user
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pendamping berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function pemantauanPKH()
    {
        $user = Auth::user();
        $pendampingProfile = $user->pendamping;

        if (!$pendampingProfile) {
            return redirect()->route('dashboard')->with('error', 'Profile pendamping tidak ditemukan');
        }

        // Ambil data penerima yang sudah disetujui untuk pemantauan
        $penerima = User::where('role', 'penerima')
            ->whereHas('pendaftaran', function ($query) use ($pendampingProfile) {
                $query->where('pendamping_id', $pendampingProfile->id)
                    ->where('status', 'approved');
            })
            ->with(['pendaftaran', 'pencairanDana', 'absensiPertemuan'])
            ->get();

        return view('pendamping.pemantauanPKH', [
            'penerima' => $penerima,
            'pendampingProfile' => $pendampingProfile
        ]);
    }

    public function detailPemantauan($id)
    {
        $user = Auth::user();
        $pendampingProfile = $user->pendamping;

        $penerima = User::with(['pendaftaran', 'pencairanDana', 'absensiPertemuan', 'laporanBulanan'])
            ->findOrFail($id);

        // Pastikan penerima ini adalah tanggung jawab pendamping yang login
        $isPenerimaValid = $penerima->pendaftaran()
            ->where('pendamping_id', $pendampingProfile->id)
            ->where('status', 'approved')
            ->exists();

        if (!$isPenerimaValid) {
            abort(403, 'Unauthorized - Penerima bukan tanggung jawab Anda');
        }

        $tahunSekarang = Carbon::now()->year;
        $bulanSekarang = Carbon::now()->month;

        return view('pendamping.detail-pemantauan', compact('penerima', 'tahunSekarang', 'bulanSekarang'));
    }
}
