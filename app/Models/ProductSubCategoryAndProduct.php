<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSubCategoryAndProduct extends Model
{
    use HasFactory;

    protected $table = 'product_subcategory_and_product';
    protected $primaryKey = 'id';
    
    const DISABLED = 'disabled';
    const ENABLED = 'enabled';

    const display_statuses = [
        0 => self::DISABLED,
        1 => self::ENABLED,
    ];

    protected $fillable = [
        'id',
        'product_subcategory_id',
        'product_id',
        'product_sequence',
    ];
}
