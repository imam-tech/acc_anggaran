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
}
