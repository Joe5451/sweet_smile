<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    use HasFactory;

    protected $table = 'home_slider';

    protected $fillable = [
        'id',
        'slider_img',
        'link',
        'sequence',
        'display',
    ];
}
