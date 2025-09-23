<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tamu', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('alamat');
            $table->string('no_telepon', 20);
            $table->string('tujuan');
            $table->string('email');
            $table->integer('jumlah_rombongan')->default(1);

            // Relasi ke tabel jenis_identitas
            $table->foreignId('jenis_identitas_id')->constrained('jenis_identitas');

            // Relasi ke tabel role
            $table->foreignId('role_id')->constrained('role');

            $table->enum('status', ['belum_checkin', 'checkin', 'approved', 'checkout'])->default('belum_checkin');
            $table->string('qr_code')->nullable();
            $table->timestamp('checkin_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('checkout_at')->nullable();

            // Relasi ke tabel users
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->foreignId('checkin_by')->nullable()->constrained('users');
            $table->foreignId('checkout_by')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tamu');
    }
};
