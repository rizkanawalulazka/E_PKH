<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laporan_bulanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('bulan'); // 1-12
            $table->integer('tahun');
            $table->text('kondisi_keluarga');
            $table->text('pencapaian_komitmen');
            $table->text('kendala')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->foreignId('pendamping_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['user_id', 'bulan', 'tahun']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_bulanan');
    }
};