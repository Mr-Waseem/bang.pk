<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
	protected $fillable = [
		'purchase_id',
		'party_id',
		'product_id',
		'tax_id',
		'uom_id',
		'warehouse_id',
		'quantity',
		'remaining_quantity',
		'unit_cost',
		'expiry',
		'total_cost',
		'company_id'
	];
	public function purchase_tax()
	{
		return $this->belongsTo('App\Models\Tax', 'tax_id');
	}

	public function purchase()
	{
		return $this->belongsTo('App\Models\Purchase');
	}

	public function products()
	{
		return $this->belongsTo('App\Models\Product', 'product_id');
	}

	public function unit()
	{
		return $this->belongsTo('App\Models\UOM', 'uom_id');
	}

	public function party()
	{
		return $this->belongsTo('App\Models\Party', 'party_id');
	}
}
