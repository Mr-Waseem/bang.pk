<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banks;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bank = new Banks();
        $bank->code = '001';
        $bank->name = 'MEEZAN BANK';
        $bank->company_id = 1;
        $bank->save();
    }
}
