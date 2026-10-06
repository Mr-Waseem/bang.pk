<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vr_no', 10);
            $table->date('vr_date');
            $table->date('attendance_date');
            $table->string('shop_id', 50);
            $table->string('biller_id', 50);
            $table->integer('company_id')->nullable();
            $table->timestamps();
        });

        Schema::create('attendance_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attendance_id')->unsigned()->nullable();
            $table->integer('employee_id')->unsigned();
            $table->integer('biller_id')->unsigned();
            $table->integer('shop_id')->unsigned();
            $table->integer('cash_payment_id')->unsigned()->nullable();
            $table->date('vr_date');
            $table->datetime('in_time')->nullable();
            $table->datetime('out_time')->nullable();
            $table->string('status', 10)->nullable();
            $table->decimal('cash_payment', 20, 2)->nullable();
            $table->integer('company_id')->nullable();
            $table->string('tax')->nullable();
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
