<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadImg extends Model
{
    use HasFactory;

    protected $table = 'head_img';

    protected $fillable = [
        'id',
        'page_name',
        'img',
    ];
}
