<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscountAmountToSaleTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('sale_taxes', 'discount_amount')) {
            Schema::table('sale_taxes', function (Blueprint $table) {
                $table->decimal('discount_amount', 20, 2)->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('sale_taxes', 'discount_amount')) {
            Schema::table('sale_taxes', function (Blueprint $table) {
                $table->dropColumn('discount_amount');
            });
        }
    }
}
