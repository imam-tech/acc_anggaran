<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoaPosting extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'coa_postings';
    protected $guarded = [];
}
