<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasePayment extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'purchase_payments';
    protected $guarded = [];

    public function coa() {
        return $this->hasOne(Coa::class, 'id', 'pay_from');
    }

    public function payment_method() {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method');
    }

    public function purchase() {
        return $this->hasOne(Purchase::class, 'id', 'purchase_id');
    }

    public function purchase_payment_attachments() {
        return $this->hasMany(PurchasePaymentAttachment::class, 'purchase_payment_id', 'id');
    }

    public function purchase_payment_journals() {
        return $this->hasMany(PurchasePaymentJournal::class, 'purchase_payment_id', 'id');
    }
}
