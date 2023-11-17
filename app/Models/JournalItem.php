<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'journal_items';
    protected $guarded = [];

    public function account() {
        return $this->hasOne(Coa::class, 'id', 'account_id');
    }

    public function cashflow() {
        return $this->hasOne(Cashflow::class, 'id', 'cashflow_id');
    }
}
