<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class PurchaseMilk extends Model
{
	protected $fillable = ['bill_no', 'date', 'vehicle_id', 'volume', 'fat', 'lr', 'rate', 'snf', 'type', 'rs5', 'fat5p', 'rs13', 'ts13', 'comments', 'biller_id'];

	public function supplier()
	{
		return $this->belongsTo('App\Models\Party', 'supplier_id');
	}
	public function vehicle()
	{
		return $this->belongsTo('App\Models\Vehicle', 'vehicle_id');
	}


	public function ledger()
	{
		return $this->belongsTo('App\Models\GeneralVoucher', 'supplier_id');
	}

	public function billers()
	{
		return $this->belongsTo('App\Models\User', 'biller_id');
	}
}
