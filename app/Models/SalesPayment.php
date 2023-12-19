<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesPayment extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'sales_payments';
    protected $guarded = [];

    public function coa() {
        return $this->hasOne(Coa::class, 'id', 'deposit_to');
    }

    public function payment_method() {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method');
    }

    public function sales() {
        return $this->hasOne(Sales::class, 'id', 'sales_id');
    }

    public function sales_payment_attachments() {
        return $this->hasMany(SalesPaymentAttachment::class, 'sales_payment_id', 'id');
    }

    public function sales_payment_journals() {
        return $this->hasMany(SalesPaymentJournal::class, 'sales_payment_id', 'id');
    }
}
