<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pendamping;
use Illuminate\Http\Request;
use App\Models\LaporanPendampingan;
use Illuminate\Support\Facades\Auth;

class PendampingController extends Controller
{
    public function index()
    {
        $pendamping = Pendamping::first();
        $penerima = User::where('role', 'penerima')->get();
        
        return view('pendamping.index', [
            'pendamping' => $pendamping,
            'penerima' => $penerima,
            'title' => 'Dashboard Pendamping',
            'menuPendamping' => 'active'
        ]);
    }

    public function daftarPenerima()
    {
        $pendamping = Pendamping::first();
        $penerima = User::where('role', 'penerima')->get();
        
        return view('pendamping.daftar-penerima', [
            'pendamping' => $pendamping,
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

    public function list()
    {
        $pendampings = \App\Models\Pendamping::with('user')->get();
        return view('pendamping.list', [
            'pendampings' => $pendampings,
            'title' => 'Daftar Pendamping',
            'menuPendampingList' => 'active',
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
}
