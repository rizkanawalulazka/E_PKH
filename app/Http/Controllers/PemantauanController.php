<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\PencairanDana;
use App\Models\AbsensiPertemuan;
use App\Models\LaporanBulanan;
use App\Models\Pendamping;
use Carbon\Carbon;

class PemantauanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Pastikan hanya pendamping dan admin yang bisa akses
        if (!in_array($user->role, ['pendamping', 'admin'])) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        if ($user->role === 'admin') {
            // Admin melihat semua penerima dari semua pendamping
            $penerima = User::where('role', 'penerima')
                ->whereHas('pendaftaran', function($query) {
                    $query->where('status', 'approved')
                          ->whereNotNull('pendamping_id');
                })
                ->with(['pendaftaran' => function($query) {
                    $query->where('status', 'approved')
                          ->whereNotNull('pendamping_id')
                          ->with('pendamping.user'); // Load pendamping info
                }])
                ->get();
        } else {
            // Pendamping melihat hanya penerima yang didampinginya
            $pendampingProfile = $user->pendamping;
            
            $penerima = User::where('role', 'penerima')
                ->whereHas('pendaftaran', function($query) use ($pendampingProfile) {
                    $query->where('pendamping_id', $pendampingProfile->id)
                          ->where('status', 'approved');
                })
                ->with(['pendaftaran' => function($query) use ($pendampingProfile) {
                    $query->where('pendamping_id', $pendampingProfile->id)
                          ->where('status', 'approved')
                          ->with('pendamping.user');
                }])
                ->get();
        }

        return view('pendamping.pemantauanPKH', [
            'penerima' => $penerima,
            'title' => 'Pemantauan PKH',
            'isAdmin' => $user->role === 'admin'
        ]);
    }

    public function show($id)   
    {
        $user = auth()->user();
        
        // Pastikan hanya pendamping dan admin yang bisa akses
        if (!in_array($user->role, ['pendamping', 'admin'])) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        if ($user->role === 'admin') {
            // Admin bisa melihat detail penerima mana pun
            $penerima = User::where('role', 'penerima')
                ->where('id', $id)
                ->whereHas('pendaftaran', function($query) {
                    $query->where('status', 'approved')
                          ->whereNotNull('pendamping_id');
                })
                ->with([
                    'pendaftaran.pendamping.user',
                    'pencairanDana',
                    'absensiPertemuan',
                    'laporanBulanan'
                ])
                ->first();
        } else {
            // Pendamping hanya bisa melihat penerima yang didampinginya
            $pendampingProfile = $user->pendamping;
            
            $penerima = User::where('role', 'penerima')
                ->where('id', $id)
                ->whereHas('pendaftaran', function($query) use ($pendampingProfile) {
                    $query->where('pendamping_id', $pendampingProfile->id)
                          ->where('status', 'approved');
                })
                ->with([
                    'pendaftaran.pendamping.user',
                    'pencairanDana',
                    'absensiPertemuan',
                    'laporanBulanan'
                ])
                ->first();
        }
        
        if (!$penerima) {
            abort(403, 'Unauthorized - Penerima tidak ditemukan atau tidak memiliki akses.');
        }

        $tahunSekarang = Carbon::now()->year;
        $bulanSekarang = Carbon::now()->month;

        return view('pendamping.detail-pemantauan', [
            'penerima' => $penerima,
            'tahunSekarang' => $tahunSekarang,
            'bulanSekarang' => $bulanSekarang,
            'title' => 'Detail Pemantauan',
            'isAdmin' => $user->role === 'admin'
        ]);
    }

    public function updatePencairan(Request $request, $id)
    {
        $user = auth()->user();
        
        // Pastikan hanya pendamping dan admin yang bisa update
        if (!in_array($user->role, ['pendamping', 'admin'])) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        // Validasi akses untuk pendamping (tidak berlaku untuk admin)
        if ($user->role === 'pendamping') {
            $pendampingProfile = $user->pendamping;
            
            $penerima = User::where('role', 'penerima')
                ->where('id', $id)
                ->whereHas('pendaftaran', function($query) use ($pendampingProfile) {
                    $query->where('pendamping_id', $pendampingProfile->id)
                          ->where('status', 'approved');
                })
                ->first();
                
            if (!$penerima) {
                return redirect()->route('dashboard')->with('error', 'Akses ditolak - Penerima bukan tanggung jawab Anda.');
            }
        }

        $request->validate([
            'periode' => 'required|integer|between:1,4',
            'tahun' => 'required|integer',
            'jumlah' => 'required|numeric|min:0',
            'tanggal_cair' => 'required|date',
            'status' => 'required|in:pending,dicairkan,ditunda'
        ]);

        PencairanDana::updateOrCreate(
            [
                'user_id' => $id,
                'periode' => $request->periode,
                'tahun' => $request->tahun
            ],
            [
                'jumlah' => $request->jumlah,
                'tanggal_cair' => $request->tanggal_cair,
                'status' => $request->status,
                'keterangan' => $request->keterangan
            ]
        );

        return redirect()->back()->with('success', 'Data pencairan berhasil diperbarui');
    }

    public function updateAbsensi(Request $request, $id)
    {
        $user = auth()->user();
        
        // Pastikan hanya pendamping dan admin yang bisa update
        if (!in_array($user->role, ['pendamping', 'admin'])) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        // Validasi akses untuk pendamping (tidak berlaku untuk admin)
        if ($user->role === 'pendamping') {
            $pendampingProfile = $user->pendamping;
            
            $penerima = User::where('role', 'penerima')
                ->where('id', $id)
                ->whereHas('pendaftaran', function($query) use ($pendampingProfile) {
                    $query->where('pendamping_id', $pendampingProfile->id)
                          ->where('status', 'approved');
                })
                ->first();
                
            if (!$penerima) {
                return redirect()->route('dashboard')->with('error', 'Akses ditolak - Penerima bukan tanggung jawab Anda.');
            }
        }

        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer',
            'status' => 'required|in:hadir,tidak_hadir,sakit,izin'
        ]);

        AbsensiPertemuan::updateOrCreate(
            [
                'user_id' => $id,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun
            ],
            [
                'status' => $request->status,
                'keterangan' => $request->keterangan,
                'tanggal_pertemuan' => $request->tanggal_pertemuan
            ]
        );

        return redirect()->back()->with('success', 'Data absensi berhasil diperbarui');
    }

    public function updateLaporan(Request $request, $id)
    {
        $user = auth()->user();
        
        // Pastikan hanya pendamping dan admin yang bisa update
        if (!in_array($user->role, ['pendamping', 'admin'])) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        // Validasi akses untuk pendamping (tidak berlaku untuk admin)
        if ($user->role === 'pendamping') {
            $pendampingProfile = $user->pendamping;
            
            $penerima = User::where('role', 'penerima')
                ->where('id', $id)
                ->whereHas('pendaftaran', function($query) use ($pendampingProfile) {
                    $query->where('pendamping_id', $pendampingProfile->id)
                          ->where('status', 'approved');
                })
                ->first();
                
            if (!$penerima) {
                return redirect()->route('dashboard')->with('error', 'Akses ditolak - Penerima bukan tanggung jawab Anda.');
            }
        }

        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer',
            'kondisi_keluarga' => 'required|string',
            'pencapaian_komitmen' => 'required|string',
            'kendala' => 'nullable|string',
            'rekomendasi' => 'nullable|string'
        ]);

        // Untuk admin, gunakan pendamping_id dari pendaftaran penerima
        if ($user->role === 'admin') {
            $penerima = User::with('pendaftaran')->find($id);
            $pendampingId = $penerima->pendaftaran->first()->pendamping_id;
        } else {
            $pendampingId = $user->pendamping->id;
        }

        LaporanBulanan::updateOrCreate(
            [
                'user_id' => $id,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun
            ],
            [
                'kondisi_keluarga' => $request->kondisi_keluarga,
                'pencapaian_komitmen' => $request->pencapaian_komitmen,
                'kendala' => $request->kendala,
                'rekomendasi' => $request->rekomendasi,
                'pendamping_id' => $pendampingId
            ]
        );

        return redirect()->back()->with('success', 'Laporan bulanan berhasil diperbarui');
    }

    // Method baru untuk admin melihat semua data pemantauan
    public function adminOverview()
    {
        $user = auth()->user();
        
        if ($user->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        // Statistik pemantauan
        $totalPenerima = User::where('role', 'penerima')
            ->whereHas('pendaftaran', function($query) {
                $query->where('status', 'approved')
                      ->whereNotNull('pendamping_id');
            })
            ->count();

        $totalPendamping = Pendamping::where('status', 'active')->count();

        $pencairanBulanIni = PencairanDana::where('status', 'dicairkan')
            ->whereMonth('tanggal_cair', Carbon::now()->month)
            ->whereYear('tanggal_cair', Carbon::now()->year)
            ->sum('jumlah');

        $absensiHadirBulanIni = AbsensiPertemuan::where('status', 'hadir')
            ->where('bulan', Carbon::now()->month)
            ->where('tahun', Carbon::now()->year)
            ->count();

        // Data per pendamping
        $dataPendamping = Pendamping::with('user')
            ->withCount(['pendaftaran' => function($query) {
                $query->where('status', 'approved');
            }])
            ->where('status', 'active')
            ->get();

        return view('admin.pemantauan-overview', [
            'title' => 'Overview Pemantauan PKH',
            'totalPenerima' => $totalPenerima,
            'totalPendamping' => $totalPendamping,
            'pencairanBulanIni' => $pencairanBulanIni,
            'absensiHadirBulanIni' => $absensiHadirBulanIni,
            'dataPendamping' => $dataPendamping
        ]);
    }

    // Method untuk admin melihat penerima berdasarkan pendamping
    public function showByPendamping($pendamping_id)
    {
        $user = auth()->user();
        
        if ($user->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $pendamping = Pendamping::with('user')->findOrFail($pendamping_id);

        $penerima = User::where('role', 'penerima')
            ->whereHas('pendaftaran', function($query) use ($pendamping_id) {
                $query->where('pendamping_id', $pendamping_id)
                      ->where('status', 'approved');
            })
            ->with(['pendaftaran' => function($query) use ($pendamping_id) {
                $query->where('pendamping_id', $pendamping_id)
                      ->where('status', 'approved');
            }])
            ->get();

        return view('admin.pemantauan-by-pendamping', [
            'title' => 'Pemantauan PKH - ' . $pendamping->user->name,
            'pendamping' => $pendamping,
            'penerima' => $penerima
        ]);
    }
}