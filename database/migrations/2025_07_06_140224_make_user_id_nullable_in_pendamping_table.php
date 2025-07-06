<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendamping', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['user_id']);
            
            // Ubah kolom user_id menjadi nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Tambahkan kembali foreign key constraint dengan nullable
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pendamping', function (Blueprint $table) {
            // Hapus foreign key constraint
            $table->dropForeign(['user_id']);
            
            // Ubah kolom user_id kembali menjadi not null
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            
            // Tambahkan kembali foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};