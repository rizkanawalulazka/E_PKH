<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('absensi_pertemuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('bulan'); // 1-12
            $table->integer('tahun');
            $table->enum('status', ['hadir', 'tidak_hadir', 'sakit', 'izin']);
            $table->date('tanggal_pertemuan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'bulan', 'tahun']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('absensi_pertemuan');
    }
};