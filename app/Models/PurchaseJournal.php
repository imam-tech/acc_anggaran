<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseJournal extends Model
{
    use HasFactory;
    
    protected $table = 'purchase_journals';
    protected $guarded = [];

    public function coa() {
        return $this->hasOne(Coa::class, 'id', 'account_id');
    }
}
