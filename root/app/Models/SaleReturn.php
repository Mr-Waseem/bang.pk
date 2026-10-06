<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{

	protected $table = 'sales_returns';
	protected $fillable = [
		'date',
		'invoice_no',
		'localExport',
		'biller',
		'sale_type',
		'sale_list',
		'sample_description',
		'dcn_no',
		'party_id',
		'due_date',
		'particulars'
	];

	public function sale_return_details()
	{
		return $this->hasMany('App\Models\SaleReturnDetails', 'sale_id');
	}

	public function parties()
	{
		return $this->belongsTo('App\Models\Party', 'party_id');
	}

	public function billers()
	{
		return $this->belongsTo('App\Models\User', 'biller');
	}
}
