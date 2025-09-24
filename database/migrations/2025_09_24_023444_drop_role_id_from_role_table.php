<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('role', function (Blueprint $table) {
            if (Schema::hasColumn('role', 'role_id')) {
                $table->dropColumn('role_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('role', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable();
        });
    }
};
