<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pendamping;
use Illuminate\Http\Request;

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
        return redirect()->route('pendamping.index')->with('error', 'Fitur laporan pendampingan tidak tersedia.');
    }

    public function simpanLaporan(Request $request)
    {
        return redirect()->route('pendamping.index')->with('error', 'Fitur laporan pendampingan tidak tersedia.');
    }

    public function daftarLaporan()
    {
        return view('pendamping.daftar-laporan', [
            'pendamping' => Pendamping::first(),
            'laporan' => [],
            'title' => 'Daftar Laporan Pendampingan',
            'menuLaporan' => 'active'
        ]);
    }
}
