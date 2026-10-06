<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('quotations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('vr_no', 100);
            $table->date('from_date', 50);
            $table->date('to_date', 50);
            $table->integer('account_id')->unsigned();
            $table->string('reference', 300);
            $table->string('best_prices', 200);
            $table->string('note', 300);
            $table->string('best_regards', 200);
            $table->string('biller', 100);
            $table->timestamps();
            
        });

        Schema::create('quotation_details', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('quotation_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('uom_id')->unsigned();
            $table->string('description', 500);
            $table->decimal('rate', 20, 2);
            $table->decimal('gst', 20, 2);
            $table->decimal('amount', 20, 2);
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
