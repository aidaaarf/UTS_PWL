<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LogActivityModel;


class LogActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LogActivityModel::insert([
            [
                'user_id' => 1, 
                'action' => 'login', 
            ],
            [
                'user_id' => 1, 
                'action' => 'logout', 
            ],
            [
                'user_id' => 2, 
                'action' => 'login', 
            ],
            [
                'user_id' => 2, 
                'action' => 'logout', 
            ]
        ]);
    }
}
