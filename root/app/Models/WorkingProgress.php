<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingProgress extends Model
{
    use HasFactory;
    protected $table = 'working_progress';
    protected $fillable = ['product_id', 'company_name', 'warehouse_id', 'account_id', 'voucher_no', 'uom_id', 'stockin', 'stockout', 'biller_id', 'rate', 'cost_amount', 'date'];
}