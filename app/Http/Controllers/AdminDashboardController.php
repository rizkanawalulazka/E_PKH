<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pendamping;
use App\Models\Pendaftaran;
use App\Models\LaporanPendampingan;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total User (role penerima)
        $totalUser = User::where('role', 'penerima')->count();

        // Pendamping Aktif
        $pendampingAktif = Pendamping::where('status', 'aktif')->count();

        // Pendaftaran Baru (belum disetujui)
        $pendaftaranBaru = Pendaftaran::where('status', 'pending')->count();

        // Laporan Masuk (belum disetujui admin)
        $laporanMasuk = LaporanPendampingan::where('status', 'pending')->count();

        return view('admin-dashboard', compact(
            'totalUser',
            'pendampingAktif',
            'pendaftaranBaru',
            'laporanMasuk'
        ));
    }
}