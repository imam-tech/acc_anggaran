<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseProduct extends Model
{
    use HasFactory;
    
    protected $table = 'purchase_products';
    protected $guarded = [];

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function tax() {
        return $this->hasOne(Tax::class, 'id', 'tax_id');
    }
}
