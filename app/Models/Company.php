<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'companies';
    protected $guarded = [];

    public function projects() {
        return $this->hasMany(Project::class, 'company_id', 'id');
    }

    public function companyAdmins() {
        return $this->hasMany(CompanyAdmin::class, 'company_id', 'id');
    }

    public function settingFlip() {
        return $this->hasOne(SettingFlip::class, 'id', 'setting_flip_id');
    }

    public function settingViews() {
        return $this->hasMany(SettingView::class, 'app_id', 'app_id');
    }

    public function max_company() {
        return $this->hasOne(SettingGeneral::class, 'app_id', 'app_id')->where('label', 'max_company');
    }
}
