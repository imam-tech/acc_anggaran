<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class App extends Model
{
    use HasFactory;
    
    protected $table = 'apps';
    protected $guarded = [];

    public function users() {
        return $this->hasMany(User::class, 'app_id', 'id');
    }

    public function setting_views() {
        return $this->hasMany(SettingView::class, "app_id", 'id');
    }

    public function max_company() {
        return $this->hasOne(SettingGeneral::class, 'app_id', 'id')->where('label', 'max_company');
    }
}
