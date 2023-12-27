<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUnit extends Model
{
    use HasFactory;
    
    protected $table = 'product_units';
    protected $guarded = [];

    public $timestamps = false;

    public function product() {
        return $this->hasOne(Product::class, 'product_unit_id', 'id');
    }
}
