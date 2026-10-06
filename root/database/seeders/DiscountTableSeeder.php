<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;

class DiscountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $discount = new Discount();
        $discount->title = 'No Discount';
        $discount->discount = '0.00';
        $discount->type = 'Percentage (%)';
        $discount->save();
    }
}
