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

    public function contact() {
        return $this->hasOne(Contact::class, 'id', 'contact_id');
    }

    public function purchase_payments() {
        return $this->hasMany(PurchasePayment::class, 'purchase_id', 'id');
    }

    public function tag_details() {
        return $this->hasMany(TagDetail::class, 'transaction_id', 'id')->where('type', 'purchase');
    }
}
