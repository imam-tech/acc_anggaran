<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesPaymentJournal extends Model
{
    use HasFactory;
    
    protected $table = 'sales_payment_journals';
    protected $guarded = [];

    public function coa() {
        return $this->hasOne(Coa::class, 'id', 'account_id');
    }
}
