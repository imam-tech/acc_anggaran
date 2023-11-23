<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory;
    
    protected $table = 'permissions';
    protected $guarded = [];

    public function rolePermissions() {
        return $this->hasMany(RolePermission::class, 'permission_id', 'id');
    }
}
