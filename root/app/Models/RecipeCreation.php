<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeCreation extends Model
{
	protected $table = "recipecreations";
	protected $fillable = ['vr_no', 'date', 'recipe_id', 'company_id', 'biller'];

	public function recipe_details()
	{
		return $this->hasMany('App\Models\RecipeCreationDetails', 'recipecreation_id')->orderBy('id');
	}


	public function billers()
	{
		return $this->belongsTo('App\Models\User', 'biller');
	}

	public function recipes()
	{
		return $this->belongsTo('App\Models\Product', 'recipe_id');
	}
}
