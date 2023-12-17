<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesPaymentAttachment extends Model
{
    use HasFactory;
    
    protected $table = 'sales_payment_attachments';
    protected $guarded = [];
}
