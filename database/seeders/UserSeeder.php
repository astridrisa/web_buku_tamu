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
            'kopeg' => 'TESTSP001',
            'email' => 'satpam1@gmail.com',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'satpam2',
            'kopeg' => 'TESTSP002',
            'email' => 'satpam2@gmail.com',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Wawan Dwi Apriyatna',
            'kopeg' => 'SP001',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Angga Suwignyo',
            'kopeg' => 'SP002',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Riska Puji Lestari',
            'kopeg' => 'SP003',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'David Dirgantara',
            'kopeg' => 'SP004',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Gunawan',
            'kopeg' => 'SP005',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Ronny Gunawan',
            'kopeg' => 'SP006',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Dedy Wibowo',
            'kopeg' => 'SP007',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Eko Supriyono',
            'kopeg' => 'SP008',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Dodik Dwi Candra',
            'kopeg' => 'SP009',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Moch Wildan Aldianto',
            'kopeg' => 'SP010',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Adi Laksono',
            'kopeg' => 'SP011',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'M Rizal Ivan',
            'kopeg' => 'SP012',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Puguh Santoso',
            'kopeg' => 'SP013',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Arif Lukman Hakim',
            'kopeg' => 'SP014',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Handika Dwingky',
            'kopeg' => 'SP015',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Andhika Bayu',
            'kopeg' => 'SP016',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Wildan Aji Rifendy',
            'kopeg' => 'SP017',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Adis Pratama',
            'kopeg' => 'SP018',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Marurrudzy A Jibril',
            'kopeg' => 'SP019',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Toni Abdiansyah',
            'kopeg' => 'SP020',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);

        UserModel::create([
            'name' => 'Tri kusuma Aditia',
            'kopeg' => 'SP021',
            'password' => Hash::make('12345'),
            'role_id' => 3,
        ]);


        // Admin
        UserModel::create([
            'name' => 'admin',
            'kopeg' => 'AD001',
            'email' => 'admin@gmail.com'   ,
            'password' => Hash::make('admin123'),               
            'role_id' => 1,
        ]);

    }
}