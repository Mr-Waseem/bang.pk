<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SROSchedule extends Model
{
    protected $table = "sro_schedules";
    use HasFactory;
    protected $fillable = ['scenario_id', 'sro_schedule_name', 'type'];

    
    public function scenario()
	{
		return $this->BelongsTO('App\Models\Scenario', 'scenario_id');
	}
}
