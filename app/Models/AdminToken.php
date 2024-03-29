<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminToken extends Model
{
    use HasFactory;

    protected $table = 'admin_token';
  
    protected $fillable = [
        'id',
        'token',
        'expires_in'
    ];
}
