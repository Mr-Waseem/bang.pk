<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LCInformatinDetail extends Model
{
    protected $table = "lc_information_details";
   protected $fillable = ['lc_info_id', 'product_id','party_id','uom_id','qty_mt','qty_kg','us_rate','rs_rate','us_amount','rs_amount'];
}
