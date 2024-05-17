<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class AdminUser extends Authenticatable
{
    use SoftDeletes, HasFactory, HasApiTokens, Notifiable;

    protected $connection = "mysql";
    protected $table = 'admin_users';

    protected $guarded = [];
    public $guard_name = 'admin';
    protected $hidden = [
        'password',
    ];
}
