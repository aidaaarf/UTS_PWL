<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    use HasFactory;
    protected $table = 'kategori';

    protected $fillable = ['kode', 'nama'];

    public function barang()
    {
        return $this->hasMany(BarangModel::class, 'kategori_id', 'id');
    }

}
