<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawMaterialStock extends Model
{
	protected $fillable = [
		'purchase_id',
		'sale_id',
		'purchase_return_id',
		'sale_return_id',
		'production_id',
		'direct_transferID',
		'purchase_milk_id',
		'warehouse_id',
		'product_id',
		'uom_id',
		'date',
		'voucher_no',
		'cost_amount',
		'stockin',
		'stockout',
		'company_id'
	];

	public function uoms()
	{
		return $this->belongsTo('App\Models\UOM', 'uom_id');
	}

	public function warehouse()
	{
		return $this->belongsTo('App\Models\Warehouse', 'warehouse_id');
	}

	public function products()
	{
		return $this->belongsTo('App\Models\Product', 'product_id');
	}
	public function parties()
	{
		return $this->belongsTo('App\Models\Party', 'party_id');
	}
	
}
