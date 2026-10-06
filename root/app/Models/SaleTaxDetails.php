<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleTaxDetails extends Model
{
	protected $fillable = [
		'sale_id', 'sale_type1', 'date', 'invoice_no', 'fbr_invoice_no', 'product_id', 'party_id', 'uom_id', 'fbr_uom_id', 'fbr_uom_desc', 'warehouse_id',
		'quantity', 'fbr_qty', 'status', 'rate', 'stvalue', 'taxvalue', 'extratax', 'extraTaxValue', 'price', 'discount', 'discountvalue', 'discount2', 'discountvalue2',
		'total', 'sro_schd_no', 'sro_item_no', 'company_id', 'remarks'
	];

	public function products()
	{
		return $this->belongsTo('App\Models\Product', 'product_id');
	}

	public function unit()
	{
		return $this->belongsTo('App\Models\UOM', 'uom_id');
	}

	public function uoms()
	{
		return $this->belongsTo('App\Models\UOM', 'uom_id');
	}

	public function sale_taxes()
	{
		return $this->belongsTo('App\Models\SaleTax', 'sale_id');
	}

	
	public function party()
	{
		return $this->belongsTo(Party::class,'party_id');
	}
}
