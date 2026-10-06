<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('account_groups', function(Blueprint $table)
        // {
        //     $table->increments('id');
        //     $table->string('title', 100);
        //     $table->string('desc', 100);
        //     $table->timestamps();

        // });

        Schema::create('account_heads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_group', 100);
            $table->string('title', 100);
            $table->string('account_no', 100);
            $table->integer('company_id')->nullable();
            $table->timestamps();
        });

        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_from_id')->unsigned()->nullable();
            $table->integer('account_id')->unsigned()->nullable();
            $table->integer('shop_id')->unsigned()->nullable();
            $table->integer('postdated_id')->unsigned()->nullable();
            $table->integer('voucher_no')->unsigned();
            $table->date('voucher_date');
            $table->string('v_type', 30);
            $table->string('biller', 30);
            $table->string('tax')->nullable();
            $table->integer('company_id')->nullable();
            $table->timestamps();
        });

        Schema::create('general_vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned()->nullable();
            // $table->integer('sale_id')->unsigned()->nullable();
            // $table->integer('purchase_id')->unsigned()->nullable();
            // $table->integer('sale_ret_id')->unsigned()->nullable();
            // $table->integer('purchase_ret_id')->unsigned()->nullable();
            // $table->integer('dc_id')->unsigned()->nullable();
            // $table->integer('purchasetax_id')->unsigned()->nullable();
            // $table->integer('lc_id')->unsigned()->nullable();
            $table->integer('account_head_id')->unsigned();
            $table->integer('head_id')->nullable();
            // $table->integer('voucher_id')->unsigned()->nullable();
            // $table->integer('bank_id')->unsigned()->nullable();
            $table->integer('attendance_id')->unsigned()->nullable();
            // $table->integer('purchase_milk_id')->nullable()->unsigned();
            $table->integer('warehouse_id')->nullable()->unsigned();
            $table->integer('cheque_id')->nullable()->unsigned();
            $table->date('date');
            $table->string('voucher_no', 20);
            $table->string('invoice_no', 20)->nullable();
            $table->string('cheque_no', 50)->nullable();
            $table->string('v_type', 30);
            $table->string('narration', 300)->nullable();
            $table->string('debit', 20)->nullable();
            $table->string('credit', 20)->nullable();
            $table->integer('company_id')->nullable();
            $table->string('tax')->nullable();
            $table->timestamps();
        });

        Schema::create('bank_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_head_id')->unsigned();
            $table->date('date');
            $table->string('voucher_no', 100);
            $table->string('debit', 20)->nullable();
            $table->string('credit', 20)->nullable();
            $table->integer('company_id')->nullable();
            $table->timestamps();
        });
        Schema::create('cash_receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_head_id')->unsigned();
            $table->date('date');
            $table->string('voucher_no', 100);
            $table->decimal('amount', 20, 2);
            $table->integer('company_id')->nullable();
            $table->timestamps();
        });

        Schema::create('cash_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_head_id')->unsigned();
            $table->date('date');
            $table->string('voucher_no', 100);
            $table->decimal('amount', 20, 2);
            $table->timestamps();
        });

        Schema::create('cheque_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_head_id')->unsigned();
            $table->date('date');
            $table->string('voucher_no', 100);
            $table->string('debit', 20)->nullable();
            $table->string('credit', 20)->nullable();
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
