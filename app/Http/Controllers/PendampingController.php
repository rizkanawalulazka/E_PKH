<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pendamping;
use Illuminate\Http\Request;
use App\Models\LaporanPendampingan;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;

class PendampingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Jika user adalah penerima, redirect ke dashboard
        if ($user->role === 'penerima') {
            return redirect()->route('dashboard');
        }

        // Jika user adalah pendamping atau admin, tampilkan daftar pendamping
        if ($user->role === 'pendamping' || $user->role === 'admin') {
            $pendampings = \App\Models\Pendamping::with('user')->get();
            return view('pendamping.list', [
                'pendampings' => $pendampings,
                'title' => 'Daftar Pendamping',
                'menuPendampingList' => 'active',
            ]);
        }

        // Default fallback
        return redirect()->route('dashboard');
    }

    public function daftarPenerima()
    {
        $user = Auth::user();
        $penerima = User::where('role', 'penerima')->get();

        // Jika user adalah pendamping, tambahkan status pendampingan
        if ($user->role === 'pendamping') {
            $pendampingProfile = $user->pendamping;
            foreach ($penerima as $p) {
                // Ambil laporan terbaru untuk penerima ini dari pendamping yang sedang login
                $latestReport = LaporanPendampingan::where('pendamping_id', $pendampingProfile->id)
                    ->where('penerima_id', $p->id)
                    ->latest('tanggal') // Urutkan berdasarkan tanggal terbaru
                    ->first();

                $p->report_status = $latestReport ? $latestReport->status : null;
            }
        }

        return view('pendamping.index', [
            'penerima' => $penerima,
            'title' => 'Daftar Penerima Bantuan',
            'menuPenerima' => 'active'
        ]);
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
        $user = Auth::user();
        if ($user->role === 'admin') {
            $laporan = LaporanPendampingan::with(['pendamping.user', 'penerima'])->latest()->get();
        } else if ($user->role === 'pendamping') {
            $pendamping = $user->pendamping;
            $laporan = LaporanPendampingan::with(['pendamping.user', 'penerima'])
                ->where('pendamping_id', $pendamping->id)
                ->latest()->get();
        } else {
            $laporan = [];
        }
        return view('pendamping.daftar-laporan', [
            'laporan' => $laporan,
            'title' => 'Daftar Laporan Pendampingan',
            'menuLaporan' => 'active',
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

        // Cek status pendaftaran berdasarkan user_id (bukan NIK)
        $pendaftaran = \App\Models\Pendaftaran::where('user_id', $user->id)
            ->where('status', 'approved')
            ->with('pendamping.user') // Eager loading pendamping
            ->latest()
            ->first();

        $pendamping = null;

        if ($user->role === 'penerima' && $pendaftaran) {
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

        return view('pendamping.info-pendamping', compact('pendaftaran', 'pendamping'));
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
}
