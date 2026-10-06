<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productions', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('vr_no');
            $table->date('date');
            $table->integer('products_id')->unsigned();
            $table->integer('uoms_id')->unsigned();
            $table->decimal('quantitys', 20, 2);
            $table->decimal('rates', 20, 2);
            $table->decimal('amounts', 20, 2);
            $table->string('biller', 100);
            $table->integer('company_id')->unsigned();
            $table->timestamps();
        });

        Schema::create('productions_details', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('production_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('uom_id')->unsigned();
            $table->decimal('quantity', 20, 4);
            $table->decimal('rate', 20, 2);
            $table->decimal('amount', 20, 2);
            $table->timestamps();
        });

        Schema::create('production_stocks', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('production_id')->unsigned()->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('pro_transfer_id')->unsigned()->nullable();
            $table->integer('warehouse_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('uom_id')->unsigned();
            $table->date('date')->nullable();
            $table->string('voucher_no', 20)->nullable();
            $table->decimal('cost_amount', 20, 2);
            $table->decimal('stockin', 20, 2)->nullable();
            $table->decimal('stockout', 20, 2)->nullable();
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
