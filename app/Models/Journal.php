<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journal extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'journals';
    protected $guarded = [];

    public function journalItems() {
        return $this->hasMany(JournalItem::class, 'journal_id', 'id');
    }
}
