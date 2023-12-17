<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'sales';
    protected $guarded = [];

    public function sales_products() {
        return $this->hasMany(SalesProduct::class, 'sales_id', 'id');
    }

    public function sales_attachments() {
        return $this->hasMany(SalesAttachment::class, 'sales_id', 'id');
    }

    public function sales_journals() {
        return $this->hasMany(SalesJournal::class, 'sales_id', 'id');
    }

    public function customer() {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
