<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use HasFactory;
    
    protected $table = 'product_categories';
    protected $guarded = [];

    public $timestamps = false;

    public function product() {
        return $this->hasOne(Product::class, 'product_category_id', 'id');
    }
}
