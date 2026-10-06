<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
	protected $fillable = ['vr_no', 'date', 'products_id', 'uoms_id', 'quantitys', 'rates', 'amounts', 'biller', 'company_id'];

	public function production_details()
	{
		return $this->hasMany('App\Models\ProductionDetails', 'production_id')->orderBy('id');
	}

	public function billers()
	{
		return $this->belongsTo('App\Models\User', 'biller');
	}

	public function products()
	{
		return $this->belongsTo('App\Models\Product', 'products_id');
	}

	public function uoms()
	{
		return $this->belongsTo('App\Models\UOM', 'uoms_id');
	}
}
