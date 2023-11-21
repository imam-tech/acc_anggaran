<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingFlip extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'setting_flips';
    protected $guarded = [];
}
