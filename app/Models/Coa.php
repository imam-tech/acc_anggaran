<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coa extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'coas';
    protected $guarded = [];

    public function coaCategory() {
        return $this->hasOne(CoaCategory::class, 'id', 'category_id');
    }

    public function coaPosting() {
        return $this->hasOne(CoaPosting::class, 'id', 'posting_id');
    }

    public function journalItem() {
        return $this->hasOne(JournalItem::class, 'account_id', 'id')->where('is_first_balance', 0);
    }

    public function initialBalance() {
        return $this->hasOne(JournalItem::class, 'account_id', 'id')->where('is_first_balance', 1);
    }
}
