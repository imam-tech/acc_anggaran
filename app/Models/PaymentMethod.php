<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'payment_methods';
    protected $guarded = [];

    public function sales_payment() {
        return $this->hasOne(SalesPayment::class, 'payment_method', 'id');
    }

    public function purchase_payment() {
        return $this->hasOne(PurchasePayment::class, 'payment_method', 'id');
    }
}
