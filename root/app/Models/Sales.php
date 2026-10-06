<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
	protected $fillable = [
		'date', 'invoice_no', 'localExport', 'biller', 'sale_type',
		'sale_list', 'sample_description', 'dcn_no', 'warehouse_id', 'party_id', 'due_date',
		'particulars', 'driver', 'vehicle', 'freight', 'returnable', 'jobcard', 'chesis_no',
		'vehicle_no', 'slip_no', 'engine_no', 'company_id'
	];

	public function sale_details()
	{
		return $this->hasMany('App\Models\SaleDetail', 'sale_id')
		// ->where('company_id',session()->get('company_id'))
		->orderBy('id');
	}

	public function parties()
	{
		return $this->belongsTo('App\Models\Party', 'party_id');
	}

	public function billers()
	{
		return $this->belongsTo('App\Models\User', 'biller');
	}

	public function ledgers()
	{
		return $this->hasMany('App\Models\Ledger');
	}

	public function shop()
	{
		return $this->belongsTo('App\Models\Warehouse', 'warehouse_id');
	}
}
