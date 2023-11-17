<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionApproval extends Model
{
    use HasFactory;
    
    protected $table = 'transaction_approvals';
    protected $guarded = [];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
