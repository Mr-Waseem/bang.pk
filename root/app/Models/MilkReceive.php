<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MilkReceive extends Model
{
	protected $fillable = ['bill_no', 'date', 'vehicle_id', 'volume', 'fat', 'lr', 'rate', 'snf', 'type', 'rs5', 'fat5p', 'rs13', 'ts13', 'comments', 'biller_id'];

	public function location()
	{
		return $this->belongsTo('App\Models\Party', 'location_id');
	}

	public function vehicle()
	{
		return $this->belongsTo('App\Models\Vehicle', 'vehicle_id');
	}
}
