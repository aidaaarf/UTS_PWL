<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BarangModel;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BarangModel::insert([
            [
                'kategori_id' => 1,
                'kode' => 'BRG001',
                'nama' => 'Whiskas Basah',
                'stok' => 50
            ],
            [
                'kategori_id' => 2,
                'kode' => 'BRG002',
                'nama' => 'Kandang',
                'stok' => 20
            ],
            [
                'kategori_id' => 3,
                'kode' => 'BRG003',
                'nama' => 'Kalung Kucing',
                'stok' => 30
            ],
        ]);
    }
}
