<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockRegisterSpecificItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('stock_register_specific_items', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('purchase_id')->nullable()->unsigned();
            $table->integer('purchase_ret_id')->nullable()->unsigned();
            $table->integer('sale_id')->nullable()->unsigned();
            $table->integer('sale_ret_id')->nullable()->unsigned();
            $table->integer('dc_id')->nullable()->unsigned();
            $table->integer('purchasetax_id')->nullable()->unsigned();
            $table->integer('grn_id')->nullable()->unsigned();
            $table->integer('production_id')->nullable()->unsigned();
            $table->integer('stock_transferID')->nullable()->unsigned();
            $table->integer('direct_transferID')->nullable()->unsigned();
            $table->integer('purchase_milk_id')->nullable()->unsigned();
            $table->integer('sample_id')->nullable()->unsigned();
            $table->date('date');
            $table->string('code', 100)->nullable();
            $table->integer('party_id')->nullable()->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('recipe_id')->nullable()->unsigned();
            $table->string('voucher_type', 100);
            $table->integer('warehouse_id')->nullable()->unsigned();
            $table->integer('uom_id')->nullable()->unsigned();
            $table->string('purchase_quantity', 20)->nullable();
            $table->string('pur_ret_quantity', 20)->nullable();
            $table->string('sale_quantity', 500)->nullable();
            $table->string('sale_ret_quantity', 20)->nullable();
            $table->string('cost_rate')->nullable();
            $table->integer('company_id')->nullable();
            $table->timestamps();

            // $table->foreign('purchase_id')
            //       ->references('id')
            //       ->on('purchases')
            //       ->onDelete('cascade');
            // $table->foreign('purchase_ret_id')
            //       ->references('id')
            //       ->on('purchase_returns')
            //       ->onDelete('cascade');
            // $table->foreign('sale_id')
            //       ->references('id')
            //       ->on('sales')
            //       ->onDelete('cascade');
            // $table->foreign('sale_ret_id')
            //       ->references('id')
            //       ->on('sales_returns')
            //       ->onDelete('cascade');
            // $table->foreign('dc_id')
            //       ->references('id')
            //       ->on('delivery_challans')
            //       ->onDelete('cascade');
            // $table->foreign('grn_id')
            //       ->references('id')
            //       ->on('grns')
            //       ->onDelete('cascade');
            // $table->foreign('party_id')
            //       ->references('id')
            //       ->on('parties')
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
