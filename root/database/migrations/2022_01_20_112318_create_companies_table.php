<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('CompanyName');
            $table->string('phone', 50)->nullable();
            $table->string('address', 300)->nullable();
            $table->string('status')->nullable();
            $table->string('ntn')->nullable();
            $table->string('strn')->nullable();
            $table->string('type');
            $table->string('bill_type')->nullable();
            $table->string('ntn_show')->nullable();
            $table->string('strn_show')->nullable();
            $table->string('pos_id',250)->nullable();
            $table->string('token', 250)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
