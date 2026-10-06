<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LCApprovedDetail extends Model
{
   protected $table = "lc_approve_details";
   protected $fillable = ['lc_approve_id', 'product_id','party_id','uom_id','qty_mt','qty_kg','us_rate','rs_rate','us_amount','rs_amount'];
}
