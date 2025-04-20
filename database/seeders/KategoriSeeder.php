<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriModel;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  
        public function run(): void
        {
            KategoriModel::insert([
                ['kode' => 'KTG001', 'nama' => 'Makanan'],
                ['kode' => 'KTG002', 'nama' => 'Peralatan'],
                ['kode' => 'KTG003', 'nama' => 'Aksesoris'],
            ]);
        }
}

