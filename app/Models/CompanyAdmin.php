<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyAdmin extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'company_admins';
    protected $guarded = [];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
