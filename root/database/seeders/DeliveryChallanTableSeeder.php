<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryChallan;

class DeliveryChallanTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $grns = new DeliveryChallan();
    $grns->party_id = '1';
    $grns->type = '0';
    $grns->dcn_no = '0';
    $grns->date = '2000-01-01';
    $grns->outward_gpn = '0';
    $grns->status = '0';
    $grns->save();
  }
}
