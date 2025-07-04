<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\PencairanDana;
use App\Models\AbsensiPertemuan;
use App\Models\LaporanBulanan;
use Carbon\Carbon;

class PemantauanController extends Controller
{
    public function index()
    {
        $pendamping = auth()->user();
        $penerima = User::where('pendamping_id', $pendamping->id)
                       ->where('role', 'penerima')
                       ->with(['pendaftaran' => function($query) {
                           $query->where('status', 'disetujui');
                       }])
                       ->get();

        return view('pemantauan.index', compact('penerima'));
    }

    public function show($id)
    {
        $penerima = User::with(['pendaftaran', 'pencairanDana', 'absensiPertemuan', 'laporanBulanan'])
                       ->findOrFail($id);
        
        // Pastikan penerima ini adalah tanggung jawab pendamping yang login
        if ($penerima->pendamping_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $tahunSekarang = Carbon::now()->year;
        $bulanSekarang = Carbon::now()->month;

        return view('pemantauan.detail', compact('penerima', 'tahunSekarang', 'bulanSekarang'));
    }

    public function updatePencairan(Request $request, $id)
    {
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
                'pendamping_id' => auth()->id()
            ]
        );

        return redirect()->back()->with('success', 'Laporan bulanan berhasil diperbarui');
    }
}