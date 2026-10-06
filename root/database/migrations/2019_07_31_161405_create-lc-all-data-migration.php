<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLcAllDataMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('lc_indentors', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('indentor_name', 200);
            $table->timestamps();
        });

       Schema::create('lc_accounts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('account_name', 200);
            $table->timestamps();
        });

       Schema::create('lc_locations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('location_name', 200);
            $table->timestamps();
        });

       Schema::create('lc_informations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('biller_id')->unsigned();
            $table->string('voucher_no', 50);
            $table->date('voucher_date');
            $table->string('lc_no', 50);
            $table->string('indentor_no', 50);
            $table->string('lc_type', 100);
            $table->date('lc_date');
            $table->integer('bank_id')->unsigned();
            $table->string('currency', 20);
            $table->string('conversion_rate', 20);
            $table->string('destination', 200);
            $table->string('origin', 200);
            $table->integer('party_id')->unsigned();
            $table->integer('indentor_id')->unsigned();
            $table->date('etd');
            $table->date('eta');
            $table->date('maturity_date');
            $table->string('tracking_no', 100);
            $table->timestamps();
        });


       Schema::create('lc_information_details', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('lc_info_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('party_id')->unsigned();
            $table->integer('uom_id')->unsigned();
            $table->string('qty_mt', 100);
            $table->string('qty_kg', 100);
            $table->string('us_rate', 30);
            $table->string('rs_rate', 30);
            $table->decimal('us_amount', 20, 2);
            $table->decimal('rs_amount', 20, 2);
            $table->timestamps();
        });

       Schema::create('lc_expenses', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('biller_id')->unsigned();
            $table->string('voucher_no', 50);
            $table->date('voucher_date');
            $table->string('v_type', 20);
            $table->integer('cash_account_id')->unsigned();
            $table->integer('lc_id')->unsigned();
            $table->timestamps();
        });

       Schema::create('lc_expense_details', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('lc_expense_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->string('desc', 300);
            $table->string('receipt', 300);
            $table->timestamps();
        });

        Schema::create('lc_payments', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('biller_id')->unsigned();
            $table->string('voucher_no', 50);
            $table->date('voucher_date');
            $table->string('v_type', 20);
            $table->integer('cash_account_id')->unsigned();
            $table->timestamps();
        });

       Schema::create('lc_payment_details', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('lc_payment_id')->unsigned();
            $table->integer('lc_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->string('desc', 300);
            $table->string('payment', 300);
            $table->timestamps();
        });

       Schema::create('lc_approves', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('biller_id')->unsigned();
            $table->string('voucher_no', 50);
            $table->date('voucher_date');
            $table->string('lc_no', 50);
            $table->string('indentor_no', 50);
            $table->string('lc_type', 100);
            $table->date('lc_date');
            $table->integer('bank_id')->unsigned();
            $table->string('currency', 20);
            $table->string('conversion_rate', 20);
            $table->string('destination', 200);
            $table->string('origin', 200);
            $table->integer('party_id')->unsigned();
            $table->integer('indentor_id')->unsigned();
            $table->date('etd');
            $table->date('eta');
            $table->date('maturity_date');
            $table->string('tracking_no', 100);
            $table->string('status', 20);
            $table->timestamps();
        });


       Schema::create('lc_approve_details', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('lc_approve_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('party_id')->unsigned();
            $table->integer('uom_id')->unsigned();
            $table->string('qty_mt', 100);
            $table->string('qty_kg', 100);
            $table->string('us_rate', 30);
            $table->string('rs_rate', 30);
            $table->decimal('us_amount', 20, 2);
            $table->decimal('rs_amount', 20, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
