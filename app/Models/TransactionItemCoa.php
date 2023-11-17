<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItemCoa extends Model
{
    use HasFactory;
    
    protected $table = 'transaction_item_coas';
    protected $guarded = [];
}
