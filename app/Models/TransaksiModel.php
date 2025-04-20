<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiModel extends Model
{
    use HasFactory;
    
    protected $table = 'transaksi';
    protected $fillable = ['barang_id', 'user_id', 'keterangan', 'jumlah'];

    // Relasi ke barang
  // Di TransaksiModel.php
public function barang()
{
    return $this->belongsTo(BarangModel::class, 'barang_id');
}

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}
