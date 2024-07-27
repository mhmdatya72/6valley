<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salesperson extends Model
{
    use HasFactory;
    protected $table = 'salesperson';
    protected $hidden = ['password', 'auth_token'];

    protected $casts = [
        'is_active' => 'integer'
    ];

}

