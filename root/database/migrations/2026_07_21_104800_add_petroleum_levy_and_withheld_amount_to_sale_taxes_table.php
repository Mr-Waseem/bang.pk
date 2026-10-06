<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPetroleumLevyAndWithheldAmountToSaleTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_taxes', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_taxes', 'petroleum_levy_rate')) {
                $table->string('petroleum_levy_rate')->nullable()->after('withheld_at_source');
            }
            if (!Schema::hasColumn('sale_taxes', 'withheld_at_source_amount')) {
                $table->decimal('withheld_at_source_amount', 20, 2)->default(0)->after('petroleum_levy_rate');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_taxes', function (Blueprint $table) {
            if (Schema::hasColumn('sale_taxes', 'withheld_at_source_amount')) {
                $table->dropColumn('withheld_at_source_amount');
            }
            if (Schema::hasColumn('sale_taxes', 'petroleum_levy_rate')) {
                $table->dropColumn('petroleum_levy_rate');
            }
        });
    }
}
