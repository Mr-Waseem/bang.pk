<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LCLocation extends Model
{
    protected $fillable = ['location_name'];
    protected $table = "lc_locations";
}
