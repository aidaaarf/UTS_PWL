<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'user'; // pastikan ini sesuai dengan nama tabel kamu

    protected $fillable = [
        'role',
        'username',
        'nama',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

}
