<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom role_id setelah id
            $table->foreignId('role_id')
                  ->after('id') // opsional, supaya posisi kolom rapih
                  ->constrained('role') // relasi ke tabel roles
                  ->onDelete('cascade'); // kalau role dihapus, user terkait ikut
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']); // hapus foreign key
            $table->dropColumn('role_id');    // hapus kolom role_id
        });
    }
};
