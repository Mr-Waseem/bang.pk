<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairingDetail extends Model
{
	protected $fillable = [
		'repairing_id',
		'product_id',
		'quantity',
		'charges'
	];

	public function products()
	{
		return $this->belongsTo('App\Models\Product', 'product_id');
	}

	public function parties()
	{
		return $this->belongsTo('App\Models\Party', 'party_id');
	}
}
