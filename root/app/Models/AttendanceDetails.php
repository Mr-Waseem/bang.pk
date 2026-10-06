<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceDetails extends Model
{
	protected $fillable = [
		'attendance_id', 'employee_id', 'biller_id', 'shop_id', 'in_time',
		'out_time', 'status','company_id','tax'
	];

	public function attendances()
	{
		return $this->belongsTo('App\Models\Attendance', 'attendance_id');
	}

	public function employees()
	{
		return $this->belongsTo('App\Models\Party', 'employee_id');
	}
}
