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
        
        // Pastikan hanya pendamping yang bisa akses
        if ($user->role !== 'pendamping') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $pendampingProfile = $user->pendamping;
        
        // Ambil penerima yang didampingi oleh pendamping ini
        $penerima = User::where('role', 'penerima')
            ->whereHas('pendaftaran', function($query) use ($pendampingProfile) {
                $query->where('pendamping_id', $pendampingProfile->id)
                      ->where('status', 'approved'); // Ganti 'disetujui' dengan 'approved'
            })
            ->with(['pendaftaran' => function($query) use ($pendampingProfile) {
                $query->where('pendamping_id', $pendampingProfile->id)
                      ->where('status', 'approved');
            }])
            ->get();

        return view('pendamping.pemantauanPKH', [
            'penerima' => $penerima,
            'title' => 'Pemantauan PKH'
        ]);
    }

    public function show($id)   
    {
        $user = auth()->user();
        
        // Pastikan hanya pendamping yang bisa akses
        if ($user->role !== 'pendamping') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $pendampingProfile = $user->pendamping;
        
        // Ambil penerima dengan validasi bahwa dia didampingi oleh pendamping ini
        $penerima = User::where('role', 'penerima')
            ->where('id', $id)
            ->whereHas('pendaftaran', function($query) use ($pendampingProfile) {
                $query->where('pendamping_id', $pendampingProfile->id)
                      ->where('status', 'approved');
            })
            ->with(['pendaftaran', 'pencairanDana', 'absensiPertemuan', 'laporanBulanan'])
            ->first();
        
        if (!$penerima) {
            abort(403, 'Unauthorized - Penerima tidak ditemukan atau bukan tanggung jawab Anda.');
        }

        $tahunSekarang = Carbon::now()->year;
        $bulanSekarang = Carbon::now()->month;

        return view('pendamping.detail-pemantauan', [
            'penerima' => $penerima,
            'tahunSekarang' => $tahunSekarang,
            'bulanSekarang' => $bulanSekarang,
            'title' => 'Detail Pemantauan'
        ]);
    }

    // Method lainnya tetap sama...
    public function updatePencairan(Request $request, $id)
    {
        $user = auth()->user();
        
        if ($user->role !== 'pendamping') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
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
        
        if ($user->role !== 'pendamping') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
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
        
        if ($user->role !== 'pendamping') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer',
            'kondisi_keluarga' => 'required|string',
            'pencapaian_komitmen' => 'required|string',
            'kendala' => 'nullable|string',
            'rekomendasi' => 'nullable|string'
        ]);

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
                'pendamping_id' => $user->pendamping->id
            ]
        );

        return redirect()->back()->with('success', 'Laporan bulanan berhasil diperbarui');
    }
}