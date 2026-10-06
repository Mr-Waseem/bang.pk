<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = ['voucher_no', 'date', 'type', 'employee_id', 'image', 'id_front', 'id_back'];

    public function employee()
    {
        return $this->belongsTo('App\Models\Party', 'employee_id');
    }
}
