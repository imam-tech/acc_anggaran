<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingView extends Model
{
    use HasFactory;

    protected $table = 'setting_views';
    protected $guarded = [];
}
