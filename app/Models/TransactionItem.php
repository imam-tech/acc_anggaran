<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'transaction_items';
    protected $guarded = [];

    public function transactionItemCoas() {
        return $this->hasMany(TransactionItemCoa::class, 'transaction_item_id', 'id');
    }
}
