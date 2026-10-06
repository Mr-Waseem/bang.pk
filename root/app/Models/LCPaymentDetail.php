<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LCPaymentDetail extends Model
{
   protected $table ="lc_payment_details";
    protected $fillable = ['lc_payment_id', 'lc_id', 'account_id', 'desc', 'payment'];
}
