<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pendamping;
use App\Models\PendaftaranPKH;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Data untuk semua role
        $data = [
            'user' => $user,
            'title' => 'Dashboard',
            'menuDashboard' => 'active'
        ];

        // Tambahkan data spesifik berdasarkan role
        switch($user->role) {
            case 'admin':
                $data = array_merge($data, $this->getAdminData());
                break;
            case 'pendamping':
                $data = array_merge($data, $this->getPendampingData($user));
                break;
            case 'penerima':
                $data = array_merge($data, $this->getPenerimaData($user));
                break;
        }

        return view('dashboard', $data);
    }

    private function getAdminData()
    {
        return [
            'totalPendamping' => User::where('role', 'pendamping')->count(),
            'totalPenerima' => User::where('role', 'penerima')->count(),
            'totalPendaftaran' => PendaftaranPKH::count(),
            'pendaftaranPending' => PendaftaranPKH::where('status', 'pending')->count(),
        ];
    }

    private function getPendampingData($user)
    {
        $pendamping = $user->pendamping;
        return [
            'totalPenerima' => User::where('role', 'penerima')->count(),
            'laporanBulanIni' => $pendamping ? $pendamping->laporanPendampingan()->whereMonth('created_at', now()->month)->count() : 0,
            'pendamping' => $pendamping
        ];
    }

    private function getPenerimaData($user)
    {
        $pendaftaran = PendaftaranPKH::where('user_id', $user->id)->latest()->first();
        $pendamping = null;
        
        if ($pendaftaran && $pendaftaran->status === 'disetujui') {
            $pendamping = Pendamping::with('user')->inRandomOrder()->first();
        }

        return [
            'pendaftaran' => $pendaftaran,
            'pendamping' => $pendamping,
            'statusPendaftaran' => $pendaftaran ? $pendaftaran->status : 'belum_daftar'
        ];
    }
}
