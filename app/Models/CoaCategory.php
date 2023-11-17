<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoaCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'coa_categories';
    protected $guarded = [];

    public function childrens() {
        return $this->hasMany(static::class, 'parent_id');
    }
}
