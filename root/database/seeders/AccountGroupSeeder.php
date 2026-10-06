<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccountGroup;

class AccountGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $catagory = new AccountGroup();
        $catagory->code     = '1';
        $catagory->name = 'DEBTOR'; //Customer
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '2';
        $catagory->name = 'CREDITOR'; // SUPPLIER
        $catagory->trialType = 'c';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '3';
        $catagory->name = 'PETTY CASH';
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '4';
        $catagory->name = 'PURCHASES';
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '5';
        $catagory->name = 'SALES';
        $catagory->trialType = 'c';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '6';
        $catagory->name = 'BANK';
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '7';
        $catagory->name = 'ASSET';
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '8';
        $catagory->name = 'LIABILITY';
        $catagory->trialType = 'c';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '9';
        $catagory->name = 'ADMIN EXPENSE';
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '10';
        $catagory->name = 'DISTRIBUTION EXPENSE';
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '11';
        $catagory->name = 'OTHER DIRECT EXPENSES';
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '12';
        $catagory->name = 'DIRECT SALARY';
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '13';
        $catagory->name = 'INDIRECT SALARY';
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '14';
        $catagory->name = 'PRE PAYMENTS';
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '15';
        $catagory->name = 'CAPITAL SHARE OF OWNER';
        $catagory->trialType = 'c';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '16';
        $catagory->name = 'DRAWINGS'; //RETURN CAPITAL TO OWNER
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '17';
        $catagory->name = 'BAD DEBTS'; //PESY MAR JANA
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '18';
        $catagory->name = 'STOCK INVENTORY';
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '19';
        $catagory->name = 'PROPERTY PLANT AND EQUIPMENT';
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '20';
        $catagory->name = 'DEPRECIATION';
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '21';
        $catagory->name = 'FURNITURE AND FIXTURES';
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '22';
        $catagory->name = 'OTHER PAYABLE';
        $catagory->trialType = 'c';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '23';
        $catagory->name = 'OTHER REVENUE';
        $catagory->trialType = 'c';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '24';
        $catagory->name = 'BANK LOAN';
        $catagory->trialType = 'c';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '25';
        $catagory->name = 'AMORTIZATION'; //INTANGIBLE 
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '26';
        $catagory->name = 'ADVANCE INCOME TAX'; //INTANGIBLE 
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '27';
        $catagory->name = 'OTHER INCOME'; //INTANGIBLE 
        $catagory->trialType = 'c';
        $catagory->reportType = 'bs';
        $catagory->save();

        $catagory = new AccountGroup();
        $catagory->code   = '28';
        $catagory->name = 'MARKUP'; //INTANGIBLE 
        $catagory->trialType = 'd';
        $catagory->reportType = 'bs';
        $catagory->save();
    }
}
