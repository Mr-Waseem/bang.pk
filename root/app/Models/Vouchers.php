<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model
{
	protected $fillable = [
		'account_from_id', 'account_id', 'shop_id', 'postdated_id',
		'voucher_no', 'voucher_date', 'v_type', 'biller', 'company_id','tax'
	];

	public function voucher_details()
	{
		return $this->hasMany('App\Models\GeneralVoucher', 'transaction_id')->orderBy('id');
	}

	public function parties()
	{
		return $this->belongsTo('App\Models\Party', 'account_id');
	}

	public function billers()
	{
		return $this->belongsTo('App\Models\User', 'biller');
	}

	public function party_from()
	{
		return $this->belongsTo('App\Models\Party', 'account_from_id');
	}
}
