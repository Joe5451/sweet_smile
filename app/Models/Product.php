<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    
    const DISABLED = 'disabled';
    const ENABLED = 'enabled';

    const display_statuses = [
        0 => self::DISABLED,
        1 => self::ENABLED,
    ];

    protected $fillable = [
        'id',
        'product_name',
        'product_cover_img',
        'original_price',
        'price',
        'summary',
        'content',
        'display',
    ];

    // public function product_category() {
    //     return $this->hasOne('App\Models\ProductCategory', 'product_category_id', 'product_category_id');
    // }

    // public function product_subcategory() {
    //     return $this->hasOne('App\Models\ProductSubCategory', 'product_subcategory_id', 'product_subcategory_id');
    // }

    // public function product_options() {
    //     return $this->hasMany('App\Models\ProductOption', 'product_id', 'id')->orderBy('sequence', 'asc');
    // }

    // public function product_imgs() {
    //     return $this->hasMany('App\Models\ProductImg', 'product_id', 'id')->orderBy('sequence', 'asc');
    // }
}
