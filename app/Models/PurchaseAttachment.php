<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseAttachment extends Model
{
    use HasFactory;
    
    protected $table = 'purchase_attachments';
    protected $guarded = [];
}
