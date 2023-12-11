<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'sales_products';
    protected $guarded = [];
}
