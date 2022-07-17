<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'member';
    protected $primaryKey = 'member_id';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
    
    const DISABLED = 'disabled';
    const ENABLED = 'enabled';

    const states = [
        0 => self::DISABLED,
        1 => self::ENABLED,
    ];

    protected $fillable = [
        'member_id',
        'name',
        'mobile',
        'email',
        'password',
        'state',
        'remark',
        'token',
        'token_expires_in',
    ];
}
