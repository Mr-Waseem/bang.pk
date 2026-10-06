<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkingProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_progress', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('company_name')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('voucher_no')->nullable();
            $table->integer('uom_id')->nullable();
            $table->integer('stockin')->nullable();
            $table->integer('stockout')->nullable();
            $table->integer('biller_id')->nullable();
            $table->decimal('rate')->nullable();
            $table->decimal('cost_amount')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('working_progress');
    }
}