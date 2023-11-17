<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'transactions';
    protected $guarded = [];

    public function transactionItems() {
        return $this->hasMany(TransactionItem::class, 'transaction_id', 'id');
    }

    public function userCreatedBy() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function transactionStatuses() {
        return $this->hasMany(TransactionStatus::class, 'transaction_id', 'id');
    }

    public function project() {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function company() {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function transactionApprovals() {
        return $this->hasMany(TransactionApproval::class, 'transaction_id', 'id');
    }

    public function transactionApprovalNulls() {
        return $this->hasMany(TransactionApproval::class, 'transaction_id', 'id')->whereNull('approved_at')->whereNull('rejected_at');
    }
}
