<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'taxes';
    protected $guarded = [];

    public function sell_coa() {
        return $this->hasOne(Coa::class, 'id', 'sell_account_id');
    }

    public function buy_coa() {
        return $this->hasOne(Coa::class, 'id', 'buy_account_id');
    }

    public function sale_product() {
        return $this->hasOne(SalesProduct::class, 'tax_id', 'id');
    }

    public function purchase_product() {
        return $this->hasOne(PurchaseProduct::class, 'tax_id', 'id');
    }
}
