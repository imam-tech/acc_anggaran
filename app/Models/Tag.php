<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;
    
    protected $table = 'tags';
    protected $guarded = [];

    public $timestamps = false;

    public function sales() {
        return $this->hasMany(TagDetail::class, 'tag_id', 'id')->where('type', 'sales');
    }

    public function purchases() {
        return $this->hasMany(TagDetail::class, 'tag_id', 'id')->where('type', 'purchase');
    }
}
