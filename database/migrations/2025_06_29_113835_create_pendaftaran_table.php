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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nik', 16);
            $table->string('nama', 255);
            $table->string('tempat_lahir', 255);
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('no_hp', 13);
            $table->json('komponen'); // Untuk menyimpan array komponen PKH
            $table->string('kartu_keluarga')->nullable(); // Path file kartu keluarga
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan_admin')->nullable(); // Catatan dari admin saat approve/reject
            $table->timestamp('approved_at')->nullable(); // Kapan disetujui
            $table->timestamps();

            // Index untuk performa
            $table->index('user_id');
            $table->index('status');
            $table->index('nik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};