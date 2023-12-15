<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManufactureProductDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'manufacture_product_details';
    protected $guarded = [];

    public function manufacture_product_detail_items() {
        return $this->hasMany(ManufactureProductDetailItem::class, 'manufacture_product_detail_id', 'id');
    }

    public function semi_finished_material() {
        return $this->hasOne(SemiFinishedMaterial::class, 'id', 'semi_finished_material_id');
    }
}
