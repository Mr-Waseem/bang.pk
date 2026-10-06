<?php

namespace Database\Seeders;

use App\Models\AccountHead;
use Illuminate\Database\Seeder;

class AccountHeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountHead::create([
            'account_group'=>'1',
            'title'=>'ABC',
            'account_no'=>'123',
            'company_id'=>1
        ]);
    }
}
