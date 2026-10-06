<?php

namespace App\Models;
use App\Warehouse;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['vr_no', 'vr_date', 'attendance_date', 'shop_id', 
	'biller_id','company_id'];

    public function attendance_details()
	{
	return $this->hasMany('App\Models\AttendanceDetails', 'attendance_id')->orderBy('id');
	}

	public function shop(){
		return $this->belongsTo('App\Models\Warehouse', 'shop_id');
	}

	public function biller(){
		return $this->belongsTo('App\Models\User', 'biller_id');
	}
}
