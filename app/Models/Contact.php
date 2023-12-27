<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'contacts';
    protected $guarded = [];

    public function sales() {
        return $this->hasMany(Sales::class, 'contact_id', 'id');
    }

    public function purchases() {
        return $this->hasMany(Purchase::class, 'contact_id', 'id');
    }
}
