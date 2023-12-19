<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'sales_products';
    protected $guarded = [];

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function tax() {
        return $this->hasOne(Tax::class, 'id', 'tax_id');
    }

    public function sales() {
        return $this->hasOne(Sales::class, 'id', 'sales_id');
    }
}
