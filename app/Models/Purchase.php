<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'purchases';
    protected $guarded = [];

    public function purchase_products() {
        return $this->hasMany(PurchaseProduct::class, 'purchase_id', 'id');
    }

    public function purchase_attachments() {
        return $this->hasMany(PurchaseAttachment::class, 'purchase_id', 'id');
    }

    public function purchase_journals() {
        return $this->hasMany(PurchaseJournal::class, 'purchase_id', 'id');
    }

    public function supplier() {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }
}