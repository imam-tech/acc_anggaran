<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'projects';
    protected $guarded = [];

    public function company() {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function projectUsers() {
        return $this->hasMany(ProjectUser::class, 'project_id', 'id');
    }
}
