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

    public function material_histories() {
        return $this->hasMany(MaterialHistory::class, 'material_id', 'id');
    }
}
