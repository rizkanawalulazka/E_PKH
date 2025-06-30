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
            $table->foreignId('pendamping_id')->nullable()->after('user_id')->constrained('pendamping')->onDelete('set null');
            $table->index('pendamping_id'); // Tambahkan index untuk performa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropForeign(['pendamping_id']);
            $table->dropIndex(['pendamping_id']);
            $table->dropColumn('pendamping_id');
        });
    }
};