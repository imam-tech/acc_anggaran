<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBrand extends Model
{
    use HasFactory;
    
    protected $table = 'product_brands';
    protected $guarded = [];

    public $timestamps = false;
}
