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


        // Satpam
        UserModel::create([
            'name' => 'satpam1',
            'kopeg' => 'SP001',
            'email' => 'satpam1@gmail.com',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'satpam2',
            'kopeg' => 'SP002',
            'email' => 'satpam2@gmail.com',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        // Admin
        UserModel::create([
            'name' => 'admin1',
            'email' => 'admin1@gmail.com'   ,
            'password' => Hash::make('admin123'),               
            'role_id' => 1,
        ]);

    }
}