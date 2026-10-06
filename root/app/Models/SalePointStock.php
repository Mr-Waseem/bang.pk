<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalePointStock extends Model
{
	protected $table = "salepoint_stocks";
	protected $fillable = [
		'warehouse_id',
		'product_id',
		'uom_id',
		'cost_amount',
		'stockin',
		'stockout'
	];

	public function uoms()
	{
		return $this->belongsTo('App\Models\UOM', 'uom_id');
	}
}
