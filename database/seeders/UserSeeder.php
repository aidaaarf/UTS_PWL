<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserModel::insert([
            [
                'role' => 'admin',
                'username' => 'admin1',
                'nama' => 'Admin',
                'password' => Hash::make('112233')
            ],
            [
                'role' => 'pegawai',
                'username' => 'pegawai1',
                'nama' => 'Pegawai',
                'password' => Hash::make('12345')
            ]
        ]);
    }
}
