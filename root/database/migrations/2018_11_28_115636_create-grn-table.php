<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('grns', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('account_id')->unsigned();
            $table->date('date');
            $table->string('grn_no', 100);
            $table->string('status', 20);
            $table->timestamps();
            
            // $table->foreign('account_id')
            //       ->references('id')
            //       ->on('parties')
            //       ->onDelete('cascade');
        });
        
            Schema::create('grn_details', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('grn_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('uom_id')->unsigned();
            $table->string('quantity', 100);
            $table->string('rate', 100);
            $table->decimal('amount', 20, 2);
            $table->timestamps();
            
            // $table->foreign('grn_id')
            //       ->references('id')
            //       ->on('grns')
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
