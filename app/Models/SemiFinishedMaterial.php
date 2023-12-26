<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SemiFinishedMaterial extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'semi_finished_materials';
    protected $guarded = [];

    public function semi_finished_material_items() {
        return $this->hasMany(SemiFinishedMaterialItem::class, 'semi_finished_material_id', 'id');
    }

    public function manufacture_product_details() {
        return $this->hasMany(ManufactureProductDetail::class, 'semi_finished_material_id', 'id');
    }
}
