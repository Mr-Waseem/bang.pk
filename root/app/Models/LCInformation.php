<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LCInformation extends Model
{
	protected $table = "lc_informations";
   protected $fillable = ['biller_id', 'voucher_no', 'voucher_date','lc_no','indentor_no','lc_type','lc_date','bank_id','currency','conversion_rate','destination','origin','party_id','indentor_id','etd','eta','maturity_date','tracking_no'];
}
