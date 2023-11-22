<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionFlip extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'transaction_flips';
    protected $guarded = [];

    public function transaction() {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }
}
