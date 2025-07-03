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
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->string('no_kk', 16)->after('nik'); // Nomor Kartu Keluarga
            $table->string('foto_rumah', 500)->nullable()->after('kartu_keluarga'); // Path foto rumah
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn('no_kk');
            $table->dropColumn('foto_rumah');
        });
    }
};
