<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'materials';
    protected $guarded = [];

    public function semi_finished_material_items() {
        return $this->hasMany(SemiFinishedMaterialItem::class, 'material_id', 'id');
    }
}
