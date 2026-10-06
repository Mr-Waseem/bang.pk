<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionMilk extends Model
{
    protected $fillable = ['bill_no', 'date', 'supplier_id', 'location_id', 'volume', 'fat', 'lr', 'rate', 'snf', 'type', 'rs5', 'fat5p', 'rs13', 'ts13', 'comments', 'biller_id'];

    	public function location()
	{
		return $this->belongsTo('App\Models\Party', 'location_id');
	}

		public function supplier()
	{
		return $this->belongsTo('App\Models\Party', 'supplier_id');
	}

		public function vehicle()
	{
		return $this->belongsTo('App\Models\Vehicle', 'vehicle_id');
	}

	 	public function location_head()
	{
		return $this->belongsTo('App\Models\AccountGroup', 'location_id');
	}
	
	 	public function billers()
	{
		return $this->belongsTo('App\Models\User', 'biller_id');
	}

	 	public function all_carry_milk()
	{
		return $this->belongsTo('App\Models\CarryMilk');
	}
}
