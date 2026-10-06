<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
	protected $fillable = [
		'date',
		'invoice_no',
		'from_warehouse_id',
		'to_warehouse_id',
		'biller'
	];

	public function stock_transfer_details()
	{
		return $this->hasMany('App\Models\StockTransferDetails', 'transfer_id')->orderBy('id');
	}

	public function billers()
	{
		return $this->belongsTo('App\Models\User', 'biller');
	}

	public function warehouse_from()
	{
		return $this->belongsTo('App\Models\Warehouse', 'from_warehouse_id');
	}

	public function warehouse_to()
	{
		return $this->belongsTo('App\Models\Warehouse', 'to_warehouse_id');
	}
}
