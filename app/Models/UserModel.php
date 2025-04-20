<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{

protected $table = 'user';

protected $primaryKey = 'id';

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
