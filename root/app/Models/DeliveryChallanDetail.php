<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryChallanDetail extends Model
{
    protected $fillable = ['challan_id', 'product_id', 'uom_id', 'quantity', 'rate', 'amount'];

    public function products()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\UOM', 'uom_id');
    }
}
