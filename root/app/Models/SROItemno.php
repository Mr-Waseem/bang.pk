<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SROItemno extends Model
{
    use HasFactory;
    protected $table = "sro_items";
    protected $fillable = ['scenario_id', 'sro_schedule_id', 'sro_item_no', 'type'];

    public function scenario()
	{
		return $this->BelongsTO('App\Models\Scenario', 'scenario_id');
	}

    public function sro_scredule()
	{
		return $this->BelongsTO('App\Models\SROSchedule', 'sro_schedule_id');
	}
}
