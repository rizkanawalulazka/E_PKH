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
        $totalPenerima = User::where('role', 'penerima')
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
        
        // PERBAIKAN: Data komponen PKH untuk pie chart
        $komponenData = collect();
        
        $pendaftaranApproved = Pendaftaran::where('status', 'approved')->get();
        
        foreach ($pendaftaranApproved as $pendaftaran) {
            // Cek apakah komponen sudah array atau masih string
            if (is_string($pendaftaran->komponen)) {
                $komponenArray = json_decode($pendaftaran->komponen, true) ?? [];
            } else {
                $komponenArray = $pendaftaran->komponen ?? [];
            }
            
            // Tambahkan ke collection
            foreach ($komponenArray as $komponen) {
                $komponenData->push($komponen);
            }
        }
        
        // Kategorikan komponen
        $komponenGrouped = $komponenData->groupBy(function($item) {
            $kesehatan = ['ibu_hamil', 'balita'];
            $pendidikan = ['anak_sd', 'anak_smp', 'anak_sma'];
            $kesejahteraan = ['lansia', 'lanjut_usia', 'disabilitas_berat'];
            
            if (in_array($item, $kesehatan)) return 'Kesehatan';
            if (in_array($item, $pendidikan)) return 'Pendidikan';
            if (in_array($item, $kesejahteraan)) return 'Kesejahteraan Sosial';
            return 'Lainnya';
        })->map(function($group) {
            return $group->count();
        });
        
        // Pastikan semua kategori ada
        $komponenData = [
            'Kesehatan' => $komponenGrouped->get('Kesehatan', 0),
            'Pendidikan' => $komponenGrouped->get('Pendidikan', 0),
            'Kesejahteraan Sosial' => $komponenGrouped->get('Kesejahteraan Sosial', 0),
            'Lainnya' => $komponenGrouped->get('Lainnya', 0)
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
            'additionalData'
        ));
    }
}
