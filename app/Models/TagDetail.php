<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagDetail extends Model
{
    use HasFactory;
    
    protected $table = 'tag_details';
    protected $guarded = [];

    public $timestamps = false;

    public function tag() {
        return $this->hasOne(Tag::class, 'id', 'tag_id');
    }
}
