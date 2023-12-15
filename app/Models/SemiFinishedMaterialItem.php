<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SemiFinishedMaterialItem extends Model
{
    use HasFactory;
    
    protected $table = 'semi_finished_material_items';
    protected $guarded = [];

    public function material() {
        return $this->hasOne(Material::class, 'id', 'material_id');
    }
}
