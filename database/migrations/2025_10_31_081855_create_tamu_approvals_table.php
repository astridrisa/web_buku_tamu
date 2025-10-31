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
        Schema::create('tamu_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tamu_id');
            $table->unsignedBigInteger('pegawai_id'); // user_id dari pegawai yang approve
            $table->timestamp('approved_at');
            $table->timestamps();

            // Foreign keys
            $table->foreign('tamu_id')->references('id')->on('tamu')->onDelete('cascade');
            $table->foreign('pegawai_id')->references('id')->on('users')->onDelete('cascade');

            // Constraint: satu pegawai hanya bisa approve 1x per tamu
            $table->unique(['tamu_id', 'pegawai_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tamu_approvals');
    }
};