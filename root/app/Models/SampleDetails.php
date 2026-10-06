<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SampleDetails extends Model
{
	protected $fillable = [
		'sample_id',
		'product_id',
		'party_id',
		'uom_id',
		'discount_id',
		'biller',
		'warehouse_id',
		'quantity',
		'product_cost',
		'cost_amount',
		'discount_id',
		'sale_rate',
		'benchmark'
	];

	public function uoms()
	{
		return $this->belongsTo('App\Models\UOM', 'uom_id');
	}

	public function products()
	{
		return $this->belongsTo('App\Models\Product', 'product_id');
	}

	public function taxes()
	{
		return $this->belongsTo('App\Models\Tax', 'tax_id');
	}

	public function discount()
	{
		return $this->belongsTo('App\Models\Discount', 'discount_id');
	}

	public function ledger()
	{
		return $this->belongsTo('App\Models\Ledger', 'party_id');
	}

	// public function parties()
	// {
	// return $this->belongsTo('App\Party', 'party_id');
	// }
}
