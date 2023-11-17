<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectUser extends Model
{
    use HasFactory;
    
    protected $table = 'project_users';
    protected $guarded = [];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
