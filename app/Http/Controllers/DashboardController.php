<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\PencairanDana;
use App\Models\Pendamping;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Data untuk semua role
        $totalPenerima = User::where('role',  'penerima')
            ->whereHas('pendaftaran', function($query) {
                $query->where('status', 'approved');
            })
            ->count();
        
        $pendingPengajuan = Pendaftaran::where('status', 'pending')->count();
        
        // Data bantuan tahun ini
        $tahunSekarang = Carbon::now()->year;
        $totalBantuanTahunIni = PencairanDana::where('status', 'dicairkan')
            ->where('tahun', $tahunSekarang)
            ->sum('jumlah');
        
        $rataBantuanBulanan = $totalBantuanTahunIni > 0 ? $totalBantuanTahunIni / 12 : 0;
        
        // Data bantuan per bulan untuk chart
        $bantuanPerBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalBulan = PencairanDana::where('status', 'dicairkan')
                ->where('tahun', $tahunSekarang)
                ->whereMonth('tanggal_cair', $i)
                ->sum('jumlah');
            
            $bantuanPerBulan[] = $totalBulan / 1000000; // Convert to million
        }
        
        // PERBAIKAN: Data komponen berdasarkan form pendaftaran
        $komponenData = [
            // Kesehatan
            'Ibu Hamil' => \App\Models\Pendaftaran::where('status', 'approved')
                ->where('komponen', 'like', '%ibu_hamil%')->count(),
            'Balita (0-5 tahun)' => \App\Models\Pendaftaran::where('status', 'approved')
                ->where('komponen', 'like', '%balita%')->count(),
            'Lansia (60+ tahun)' => \App\Models\Pendaftaran::where('status', 'approved')
                ->where('komponen', 'like', '%lansia%')->count(),
            
            // Pendidikan
            'Anak SD/MI' => \App\Models\Pendaftaran::where('status', 'approved')
                ->where('komponen', 'like', '%anak_sd%')->count(),
            'Anak SMP/MTs' => \App\Models\Pendaftaran::where('status', 'approved')
                ->where('komponen', 'like', '%anak_smp%')->count(),
            'Anak SMA/MA' => \App\Models\Pendaftaran::where('status', 'approved')
                ->where('komponen', 'like', '%anak_sma%')->count(),
            
            // Kesejahteraan Sosial
            'Disabilitas Berat' => \App\Models\Pendaftaran::where('status', 'approved')
                ->where('komponen', 'like', '%disabilitas_berat%')->count(),
            'Lanjut Usia (70+ tahun)' => \App\Models\Pendaftaran::where('status', 'approved')
                ->where('komponen', 'like', '%lanjut_usia%')->count(),
        ];

        // Kelompokkan berdasarkan kategori
        $komponenKategori = [
            'Kesehatan' => $komponenData['Ibu Hamil'] + $komponenData['Balita (0-5 tahun)'] + $komponenData['Lansia (60+ tahun)'],
            'Pendidikan' => $komponenData['Anak SD/MI'] + $komponenData['Anak SMP/MTs'] + $komponenData['Anak SMA/MA'],
            'Kesejahteraan Sosial' => $komponenData['Disabilitas Berat'] + $komponenData['Lanjut Usia (70+ tahun)']
        ];

        // Data tambahan berdasarkan role
        $additionalData = [];
        
        if ($user->role === 'penerima') {
            $additionalData = [
                'pendaftaran' => $user->pendaftaran,
                'pencairan' => PencairanDana::where('user_id', $user->id)->latest()->get(),
                'total_diterima' => PencairanDana::where('user_id', $user->id)
                    ->where('status', 'dicairkan')
                    ->sum('jumlah')
            ];
        } elseif ($user->role === 'pendamping') {
            $pendamping = $user->pendamping;
            $additionalData = [
                'jumlah_penerima' => $pendamping ? $pendamping->pendaftaran()->where('status', 'approved')->count() : 0,
                'pencairan_bulan_ini' => PencairanDana::whereHas('user.pendaftaran', function($query) use ($pendamping) {
                    if ($pendamping) {
                        $query->where('pendamping_id', $pendamping->id);
                    }
                })
                ->where('status', 'dicairkan')
                ->whereMonth('tanggal_cair', Carbon::now()->month)
                ->sum('jumlah')
            ];
        }
        
        return view('dashboard', compact(
            'totalPenerima',
            'pendingPengajuan',
            'totalBantuanTahunIni',
            'rataBantuanBulanan',
            'bantuanPerBulan',
            'komponenData',
            'komponenKategori',
            'additionalData'
        ));
    }
}
