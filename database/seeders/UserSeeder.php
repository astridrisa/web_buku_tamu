<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserModel::create([
            'name' => 'security1',                // username
            'email' => 'security1@gmail.com',   // email dummy
            'password' => Hash::make('12345'),   // password hashed
            'role_id' => 1,                       // sesuaikan ID role (misal 2 = security)
        ]);

        // UserModel::create([
        //     'name' => 'admin1',
        //     'email' => 'admin1@example.com',
        //     'password' => Hash::make('admin123'),
        //     'role_id' => 1, // misal 1 = admin
        // ]);
    }
}
