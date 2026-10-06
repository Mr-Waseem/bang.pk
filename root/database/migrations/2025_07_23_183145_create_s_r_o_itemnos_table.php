<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSROItemnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sro_items', function (Blueprint $table) {
            $table->id();
            $table->integer('scenario_id')->nullable();
            $table->integer('sro_schedule_id')->nullable();
            $table->string('sro_item_no', 100);
            $table->integer('type', 1)->default(0);
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
        Schema::dropIfExists('s_r_o_itemnos');
    }
}
