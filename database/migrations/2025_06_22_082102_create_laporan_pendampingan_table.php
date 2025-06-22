<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_pendampingan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendamping_id');
            $table->unsignedBigInteger('penerima_id');
            $table->date('tanggal');
            $table->text('kegiatan');
            $table->string('status'); // Selesai/Proses
            $table->string('foto')->nullable();
            $table->enum('verifikasi_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            $table->foreign('pendamping_id')->references('id')->on('pendamping')->onDelete('cascade');
            $table->foreign('penerima_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pendampingan');
    }
};
