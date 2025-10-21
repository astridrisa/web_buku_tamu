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
        Schema::table('tamu', function (Blueprint $table) {
            // Menambahkan kolom nama_pegawai setelah kolom tujuan
            $table->string('nama_pegawai', 255)->nullable()->after('tujuan');
            
            // Menambahkan kolom foto setelah kolom nama_pegawai
            $table->string('foto', 255)->nullable()->after('nama_pegawai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tamu', function (Blueprint $table) {
            // Menghapus kolom jika rollback
            $table->dropColumn(['nama_pegawai', 'foto']);
        });
    }
};