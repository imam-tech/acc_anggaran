<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'products';
    protected $guarded = [];

    public function category() {
        return $this->hasOne(ProductCategory::class, 'id', 'product_category_id');
    }

    public function unit() {
        return $this->hasOne(ProductUnit::class, 'id', 'product_unit_id');
    }

    public function sale_tax() {
        return $this->hasOne(Tax::class, 'id', 'sale_tax_id');
    }

    public function purchase_tax() {
        return $this->hasOne(Tax::class, 'id', 'purchase_tax_id');
    }

    public function sale_coa() {
        return $this->hasOne(Coa::class, 'id', 'sale_account_id');
    }

    public function purchase_coa() {
        return $this->hasOne(Coa::class, 'id', 'purchase_account_id');
    }

    public function sale_products() {
        return $this->hasMany(SalesProduct::class, 'product_id', 'id');
    }

    public function purchase_products() {
        return $this->hasMany(PurchaseProduct::class, 'product_id', 'id');
    }
}
