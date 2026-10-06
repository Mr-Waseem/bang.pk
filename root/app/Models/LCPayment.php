<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LCPayment extends Model
{
    protected $table ="lc_payments";
    protected $fillable = ['biller_id', 'voucher_no', 'voucher_date', 'v_type', 'cash_account_id'];
}
