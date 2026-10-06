<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repairing extends Model
{
	protected $fillable = [
		'party_id',
		'date',
		'reference_no',
	];

	public function repairing_details()
	{
		return $this->hasMany('App\Models\RepairingDetail');
	}

	public function parties()
	{
		return $this->belongsTo('App\Models\Party', 'party_id');
	}
}
