<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('order_forms', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('account_id')->unsigned()->nullable();
            $table->string('voucher_no', 100);
            $table->date('voucher_date');
            $table->date('delivery_date');
            $table->string('remarks', 500);
            $table->string('v_type', 30);
            $table->integer('shop_id')->unsigned();
            $table->string('biller_id', 30);
            $table->timestamps();

        });

        Schema::create('order_form_details', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->nullable();
            $table->integer('account_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->decimal('quantity', 20,2);
            $table->decimal('price', 20,2);
            $table->integer('packing_id')->unsigned();
            $table->string('terms', 500)->nullable();
            $table->string('v_type', 30);
            $table->integer('shop_id')->unsigned();
            $table->string('biller_id', 30);
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
