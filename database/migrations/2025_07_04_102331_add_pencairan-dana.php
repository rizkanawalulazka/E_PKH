<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pencairan_dana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('periode'); // 1, 2, 3, 4
            $table->integer('tahun');
            $table->decimal('jumlah', 12, 2);
            $table->date('tanggal_cair');
            $table->enum('status', ['pending', 'dicairkan', 'ditunda']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'periode', 'tahun']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pencairan_dana');
    }
};