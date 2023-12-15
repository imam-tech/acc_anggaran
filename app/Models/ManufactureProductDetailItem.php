<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManufactureProductDetailItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'manufacture_product_detail_items';
    protected $guarded = [];
}
