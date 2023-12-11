<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashAndBank extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'cash_and_balances';
    protected $guarded = [];

    public function coa() {
        return $this->hasOne(Coa::class, 'id', 'coa_id');
    }
}
