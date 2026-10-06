<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryChallan extends Model
{
    protected $fillable = ['party_id', 'date', 'vr_no', 'type', 'outward_gpn', 'status', 'remarks', 'po_no', 'vehicle_no', 'driver_name', 'driver_phone'];

    public function challan_details()
    {
        return $this->hasMany('App\Models\DeliveryChallanDetail', 'challan_id');
    }

    public function parties()
    {
        return $this->belongsTo('App\Models\Party', 'party_id');
    }
}
