<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';
    
    const DISABLED = 'disabled';
    const ENABLED = 'enabled';

    const display_statuses = [
        0 => self::DISABLED,
        1 => self::ENABLED,
    ];

    protected $fillable = [
        'id',
        'title',
        'cover_img',
        'date',
        'summary',
        'content',
        'display',
    ];
}
