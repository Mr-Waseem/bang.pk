<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LCExpense extends Model
{
    protected $table = "lc_expenses";
    protected $fillable = ['biller_id', 'voucher_no', 'voucher_date', 'v_type', 'cash_account_id', 'lc_id'];
}
