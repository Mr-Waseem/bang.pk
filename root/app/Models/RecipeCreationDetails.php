<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeCreationDetails extends Model
{
	protected $table = "recipecreation_details";
	protected $fillable = ['recipecreation_id', 'company_id', 'recipe_id', 'product_id', 'product_code', 'uom_id', 'quantity', 'rate', 'amount'];

	public function products()
	{
		return $this->belongsTo('App\Models\Product', 'product_id');
	}

	public function uoms()
	{
		return $this->belongsTo('App\Models\UOM', 'uom_id');
	}
}
