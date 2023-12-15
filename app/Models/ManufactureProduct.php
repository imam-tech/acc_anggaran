<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManufactureProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'manufacture_products';
    protected $guarded = [];

    public function manufacture_product_details() {
        return $this->hasMany(ManufactureProductDetail::class, 'manufacture_product_id', 'id');
    }
}
