<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendampingController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PemantauanController;

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
    // Dashboard route
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return app(AdminDashboardController::class)->index();
        } elseif ($user->role === 'pendamping') {
            return app(PendampingController::class)->index(); // REDIRECT KE PENDAMPING INDEX
        } else {
            return view('dashboard'); // Default dashboard untuk penerima
        }
    })->name('dashboard');

    Route::get('/pendamping/info-pendamping', [PendampingController::class, 'infoPendamping'])->name('pendamping.infoPendamping');

    // PKH Registration routes
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.pkh.index');
    Route::get('/pendaftaran/create', [PendaftaranController::class, 'create'])->name('pendaftaran.pkh.create');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.pkh.store');
    Route::post('/pendaftaran/{id}/approve', [PendaftaranController::class, 'approve'])->name('pendaftaran.pkh.approve');
    Route::post('/pendaftaran/{id}/reject', [PendaftaranController::class, 'reject'])->name('pendaftaran.pkh.reject');

    // Pendamping routes
    Route::get('/pendamping', [PendampingController::class, 'index'])->name('pendamping.index');
    Route::get('/pendamping/daftar-penerima', [PendampingController::class, 'daftarPenerima'])->name('pendamping.penerima');

    // Route untuk pemantauan PKH - GUNAKAN PEMANTAUANCONTROLLER
    Route::get('/pendamping/pemantauan', [PemantauanController::class, 'index'])->name('pendamping.pemantauan');
    Route::get('/pendamping/pemantauan/{id}', [PemantauanController::class, 'show'])->name('pemantauan.show');

    // Route untuk laporan pendampingan
    Route::get('/pendamping/laporan', [PendampingController::class, 'daftarLaporan'])->name('pendamping.laporan');
    Route::get('/pendamping/laporan/create', [PendampingController::class, 'createLaporan'])->name('pendamping.laporan.create');
    Route::post('/pendamping/laporan/store', [PendampingController::class, 'storeLaporan'])->name('pendamping.laporan.store');

    // Route untuk update status penerima
    Route::post('/pendamping/update-status/{id}', [PendampingController::class, 'updateStatus'])->name('pendamping.update-status');

    Route::post('/admin/pendaftaran/{id}/update-status', [PendaftaranController::class, 'updateStatusPendaftaran'])->name('admin.pendaftaran.update-status');

    // Admin routes
    Route::post('/admin/pendamping/store', [PendampingController::class, 'store'])->name('pendamping.store');
    Route::get('/admin/pendamping/{id}/edit', [PendampingController::class, 'edit'])->name('pendamping.edit');
    Route::post('/admin/pendamping/{id}/update', [PendampingController::class, 'update'])->name('pendamping.update');
    Route::post('/admin/pendamping/{id}/toggle-status', [PendampingController::class, 'toggleStatus'])->name('pendamping.toggle-status');
    Route::delete('/admin/pendamping/{id}/delete', [PendampingController::class, 'destroy'])->name('pendamping.destroy');
    Route::get('/admin/pendamping/export', [PendampingController::class, 'export'])->name('pendamping.export');

    // Routes untuk Pemantauan - HAPUS MIDDLEWARE ROLE
    Route::get('/pemantauan', [PemantauanController::class, 'index'])->name('pemantauan.index');
    Route::get('/pemantauan/{id}', [PemantauanController::class, 'show'])->name('pemantauan.show');
    Route::post('/pemantauan/{id}/pencairan', [PemantauanController::class, 'updatePencairan'])->name('pemantauan.update-pencairan');
    Route::post('/pemantauan/{id}/absensi', [PemantauanController::class, 'updateAbsensi'])->name('pemantauan.update-absensi');
    Route::post('/pemantauan/{id}/laporan', [PemantauanController::class, 'updateLaporan'])->name('pemantauan.update-laporan');
});