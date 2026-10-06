<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Production;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $production = new Production();
        $production->vr_no = '0';
        $production->date = '2000-01-01';
        $production->products_id = '1';
        $production->uoms_id = '1';
        $production->quantitys = '0';
        $production->rates = '0';
        $production->amounts = '0';
        $production->biller = '1';
        $production->save();
    }
}
