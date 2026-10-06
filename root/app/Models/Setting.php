<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $fillable =
	[
		'system_name',
		'title',
		'address',
		'phone',
		'email',
		'currency',
		'city',
		'state',
		'country',
		'profile',
		'white_label',
		'login_note_title',
		'login_note_body',
	];
}
