<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryChallanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::create('delivery_challans', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('party_id')->unsigned();
            $table->string('type', 100);
            $table->string('dcn_no', 100);
            $table->date('date');
            $table->string('outward_gpn', 100);
            $table->string('status', 20);
            $table->timestamps();
            
            // $table->foreign('party_id')
            //       ->references('id')
            //       ->on('parties')
            //       ->onDelete('cascade');
        });
        
            Schema::create('delivery_challan_details', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('challan_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('uom_id')->unsigned();
            $table->string('quantity', 100);
            $table->string('rate', 100);
            $table->decimal('amount', 20, 2);
            $table->timestamps();
            
            // $table->foreign('challan_id')
            //       ->references('id')
            //       ->on('delivery-challans')
            //       ->onDelete('cascade');
                  
            // $table->foreign('product_id')
            //       ->references('id')
            //       ->on('products')
            //       ->onDelete('cascade');
                
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
