<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransaksiModel;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransaksiModel::insert([
            [
                'barang_id' => 1, 
                'user_id' => 1,   
                'keterangan' => 'masuk',
                'jumlah' => 10,
            ],
            [
                'barang_id' => 2,
                'user_id' => 1,
                'keterangan' => 'keluar',
                'jumlah' => 5,
            ],
            [
                'barang_id' => 1,
                'user_id' => 2,
                'keterangan' => 'keluar',
                'jumlah' => 2,
            ],
        ]);
    }
}
