<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    
    protected $table = 'roles';
    protected $guarded = [];

    public function rolePermissions() {
        return $this->hasMany(RolePermission::class, 'role_id', 'id');
    }
}
