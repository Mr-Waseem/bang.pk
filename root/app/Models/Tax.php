<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
	protected $fillable = [
		'tax_title',
		'tax_rate',
		'tax_type'
	];
}
