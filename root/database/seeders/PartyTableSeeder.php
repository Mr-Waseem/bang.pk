<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Party;

class PartyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $party = new Party();
        $party->account_group_id = 4;
        $party->shop_id = 2;
        $party->account_type = 'PURCHASES';
        $party->code = 0;
        $party->party_name = 'PURCHASES';
        $party->save();

        $party = new Party();
        $party->account_group_id = 5;
        $party->shop_id = 2;
        $party->account_type = 'SALES';
        $party->code = 0;
        $party->party_name = 'SALES';
        $party->save();

        $party = new Party();
        $party->account_group_id = 26;
        $party->shop_id = 2;
        $party->account_type = 'ADVANCE INCOME TAX';
        $party->code = 0;
        $party->party_name = 'ADVANCE INCOME TA';
        $party->save();

        $party = new Party();
        $party->account_group_id = 18;
        $party->shop_id = 2;
        $party->account_type = 'STOCK INVENTORY';
        $party->code = 0;
        $party->party_name = 'STOCK INVENTORY';
        $party->save();

    }
}
