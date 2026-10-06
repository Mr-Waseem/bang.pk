<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecipeCreationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipecreations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('vr_no');
            $table->date('date');
            $table->integer('recipe_id')->unsigned();
            $table->integer('company_id')->unsigned();
            // $table->integer('uoms_id')->unsigned();
            // $table->decimal('quantitys', 20, 2);
            // $table->decimal('rates', 20, 2);
            // $table->decimal('amounts', 20, 2);
            $table->string('biller', 100);
            $table->timestamps();
        });

        Schema::create('recipecreation_details', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('recipecreation_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->integer('recipe_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('product_code')->unsigned();
            $table->integer('uom_id')->unsigned();
            $table->decimal('quantity', 20, 4);
            $table->decimal('rate', 20, 2);
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
