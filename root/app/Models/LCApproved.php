<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LCApproved extends Model
{
    protected $table = "lc_approves";
    protected $fillable = ['biller_id', 'voucher_no', 'voucher_date','lc_no','indentor_no','lc_type','lc_date','bank_id','currency','conversion_rate','destination','origin','party_id','indentor_id','etd','eta','maturity_date','tracking_no', 'status'];

    public function lc_detail()
	{
	return $this->hasMany('App\LedgerDetailWise', 'lc_id');
	}

}
