<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostDatedChequeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post-dated', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('account_id')->unsigned();
            $table->string('voucher_no', 100);
            $table->date('voucher_date');
            $table->string('v_type', 30);
            $table->string('biller', 30);
            $table->string('status', 15);
            $table->timestamps();
        });

    Schema::create('post-dated-cheques', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('voucher_id')->unsigned();
            $table->integer('account_head_id')->unsigned();
            $table->integer('bank_id')->unsigned();
            $table->date('date');
            $table->string('voucher_no', 100);
            $table->string('cheque_no', 50)->nullable();
            $table->string('v_type', 30);
            $table->string('status', 10);
            $table->string('narration', 300)->nullable();
            $table->string('debit', 20)->nullable();
            $table->string('credit', 20)->nullable();
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
