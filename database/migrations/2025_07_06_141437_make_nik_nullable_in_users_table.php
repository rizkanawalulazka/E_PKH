<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus unique constraint terlebih dahulu
            $table->dropUnique(['nik']);
            
            // Ubah kolom nik menjadi nullable
            $table->string('nik', 16)->nullable()->change();
            
            // Tambahkan kembali unique constraint dengan nullable
            $table->unique('nik');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus unique constraint
            $table->dropUnique(['nik']);
            
            // Ubah kolom nik kembali menjadi not null
            $table->string('nik', 16)->nullable(false)->change();
            
            // Tambahkan kembali unique constraint
            $table->unique('nik');
        });
    }
};