<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role')->insert([
            ['id' => 1, 'nama_role' => 'Security',    'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama_role' => 'Pegawai', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
