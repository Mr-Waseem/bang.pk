<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\PurchaseReturn;

class PurchaseTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $purchases = new Purchase();
    $purchases->account_id = '1';
    $purchases->warehouse_id = '1';
    $purchases->date = '2000-01-01';
    $purchases->bill_no = '0';
    $purchases->grn_no = '0';
    $purchases->purchase_type = '0';
    $purchases->due_date = '2000-01-01';
    $purchases->particulars = '0';
    $purchases->save();

    $purchases = new PurchaseReturn();
    $purchases->account_id = '1';
    $purchases->date = '2000-01-01';
    $purchases->bill_no = '0';
    $purchases->grn_no = '0';
    $purchases->purchase_type = '0';
    $purchases->due_date = '2000-01-01';
    $purchases->particulars = '0';
    $purchases->save();
  }
}
