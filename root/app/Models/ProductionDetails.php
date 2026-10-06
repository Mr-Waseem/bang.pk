<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionDetails extends Model
{
	protected $table = "productions_details";
	protected $fillable = ['production_id', 'company_id', 'product_id', 'uom_id', 'quantity', 'rate', 'amount'];


	public function products_out()
	{
		return $this->belongsTo('App\Models\Product', 'product_id');
	}

	public function uom_pro_details()
	{
		return $this->belongsTo('App\Models\UOM', 'uom_id');
	}

	public function production()
	{
		return $this->belongsTo('App\Models\Production', 'production_id');
	}
}
