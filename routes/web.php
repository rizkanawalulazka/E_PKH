<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendampingController;
use App\Http\Controllers\PendaftaranPKHController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (perlu login)
Route::middleware(['auth'])->group(function () {
    // Dashboard route - PINDAH KE SINI
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // PKH Registration routes
    Route::get('/pendaftaran', [PendaftaranPKHController::class, 'index'])->name('pendaftaran.pkh.index');
    Route::get('/pendaftaran/create', [PendaftaranPKHController::class, 'create'])->name('pendaftaran.pkh.create');
    Route::post('/pendaftaran', [PendaftaranPKHController::class, 'store'])->name('pendaftaran.pkh.store'); // PERBAIKI URL
    Route::post('/pendaftaran/{id}/approve', [PendaftaranPKHController::class, 'approve'])->name('pendaftaran.pkh.approve');
    Route::post('/pendaftaran/{id}/reject', [PendaftaranPKHController::class, 'reject'])->name('pendaftaran.pkh.reject');
    
    // Pendamping routes
    Route::get('/pendamping', [PendampingController::class, 'index'])->name('pendamping.index');
    Route::get('/pendamping/penerima', [PendampingController::class, 'daftarPenerima'])->name('pendamping.penerima');
    Route::get('/pendamping/laporan', [PendampingController::class, 'daftarLaporan'])->name('pendamping.laporan');
    Route::get('/pendamping/laporan/buat/{penerima_id}', [PendampingController::class, 'buatLaporan'])->name('pendamping.laporan.buat');
    Route::post('/pendamping/laporan', [PendampingController::class, 'simpanLaporan'])->name('pendamping.laporan.simpan');
    Route::post('/pendamping/laporan/{id}/approve', [PendampingController::class, 'approveLaporan'])->name('pendamping.laporan.approve');
    Route::post('/pendamping/laporan/{id}/reject', [PendampingController::class, 'rejectLaporan'])->name('pendamping.laporan.reject');
    Route::get('/pendamping/info', [PendampingController::class, 'infoPendamping'])->name('pendamping.info');
    Route::post('/pendamping/penerima/{penerima_id}/update-status', [PendampingController::class, 'updatePenerimaReportStatus'])->name('pendamping.penerima.update_status');
});
