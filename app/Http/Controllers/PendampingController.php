<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pendamping;
use Illuminate\Http\Request;
use App\Models\LaporanPendampingan;
use Illuminate\Support\Facades\Auth;
use App\Models\PendaftaranPKH;

class PendampingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Jika user adalah pendamping atau admin, tampilkan daftar pendamping
        if ($user->role === 'pendamping' || $user->role === 'admin') {
            $pendampings = \App\Models\Pendamping::with('user')->get();
            return view('pendamping.list', [
                'pendampings' => $pendampings,
                'title' => 'Daftar Pendamping',
                'menuPendampingList' => 'active',
            ]);
        }

        // Jika user adalah penerima, tampilkan info pendamping acak
        $pendaftaran = \App\Models\Pendaftaran::where('nik', $user->nik)->where('status', 'approved')->latest()->first();
        $pendamping = null;

        if ($user->role === 'penerima' && $pendaftaran) {
            $pendamping = \App\Models\Pendamping::with('user')->inRandomOrder()->first();
        }
        return view('pendamping.info-pendamping', compact('pendaftaran', 'pendamping'));
    }

    public function daftarPenerima()
    {
        $penerima = User::where('role', 'penerima')->get();
        
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
        // Cek status pendaftaran (bisa dari pendaftaran atau pendaftaran_pkh, sesuaikan kebutuhan)
        $pendaftaran = \App\Models\Pendaftaran::where('nik', $user->nik)->where('status', 'approved')->latest()->first();
        $pendamping = null;

        if ($user->role === 'penerima' && $pendaftaran) {
            // Ambil satu pendamping acak dari user seeder (role pendamping)
            $pendamping = \App\Models\Pendamping::with('user')->inRandomOrder()->first();
        }

        return view('pendamping.info-pendamping', compact('pendaftaran', 'pendamping'));
    }
}
