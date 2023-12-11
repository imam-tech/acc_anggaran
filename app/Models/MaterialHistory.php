<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialHistory extends Model
{
    use HasFactory;
    
    protected $table = 'material_histories';
    protected $guarded = [];
}
