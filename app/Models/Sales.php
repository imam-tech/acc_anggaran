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

    public function contact() {
        return $this->hasOne(Contact::class, 'id', 'contact_id');
    }

    public function sales_payments() {
        return $this->hasMany(SalesPayment::class, 'sales_id', 'id');
    }

    public function tag_details() {
        return $this->hasMany(TagDetail::class, 'transaction_id', 'id')->where('type', 'sales');
    }

    public function company() {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
