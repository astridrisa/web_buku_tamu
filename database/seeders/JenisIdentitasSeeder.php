<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisIdentitas;

class JenisIdentitasSeeder extends Seeder
{
    public function run(): void
    {
        $identitas = [
            ['nama' => 'KTP'],
            ['nama' => 'SIM'],
            ['nama' => 'Paspor'],
            ['nama' => 'Kartu Pelajar'],
        ];

        foreach ($identitas as $data) {
            JenisIdentitas::create($data);}
}
}