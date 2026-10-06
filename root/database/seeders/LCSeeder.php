<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LCIndentor;
use App\Models\LCAccount;
use App\Models\LCLocation;
use App\Models\LCInformation;
use App\Models\LCExpense;
use App\Models\LCPayment;
use App\Models\LCApproved;

class LCSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $indentor = new LCIndentor();
        $indentor->indentor_name = 'TEST INDENTOR';
        $indentor->save();

        $indentor = new LCAccount();
        $indentor->account_name = 'TEST ACCOUNT';
        $indentor->save();

        $indentor = new LCLocation();
        $indentor->location_name = 'TEST LOCATION';
        $indentor->save();


        $information = new LCInformation();
        $information->biller_id = '1';
        $information->voucher_no = '0';
        $information->voucher_date = '2000-01-01';
        $information->lc_no = '0';
        $information->indentor_no = '1';
        $information->lc_type = '0';
        $information->lc_date = '2000-01-01';
        $information->bank_id = '1';
        $information->currency = '0';
        $information->conversion_rate = '0';
        $information->destination = '0';
        $information->origin = '0';
        $information->party_id = '1';
        $information->indentor_id = '1';
        $information->etd = '2000-01-01';
        $information->eta = '2000-01-01';
        $information->maturity_date = '2000-01-01';
        $information->tracking_no = '0';
        $information->save();

        $information = new LCExpense();
        $information->biller_id = '1';
        $information->voucher_no = '0';
        $information->voucher_date = '2000-01-01';
        $information->v_type = '0';
        $information->cash_account_id = '1';
        $information->lc_id = '1';
        $information->save();

        $information = new LCPayment();
        $information->biller_id = '1';
        $information->voucher_no = '0';
        $information->voucher_date = '2000-01-01';
        $information->v_type = '0';
        $information->cash_account_id = '1';
        $information->save();

        $information = new LCApproved();
        $information->biller_id = '1';
        $information->voucher_no = '0';
        $information->voucher_date = '2000-01-01';
        $information->lc_no = '0';
        $information->indentor_no = '1';
        $information->lc_type = '0';
        $information->lc_date = '2000-01-01';
        $information->bank_id = '1';
        $information->currency = '0';
        $information->conversion_rate = '0';
        $information->destination = '0';
        $information->origin = '0';
        $information->party_id = '1';
        $information->indentor_id = '1';
        $information->etd = '2000-01-01';
        $information->eta = '2000-01-01';
        $information->maturity_date = '2000-01-01';
        $information->tracking_no = '0';
        $information->status = '0';
        $information->save();
    }
}
