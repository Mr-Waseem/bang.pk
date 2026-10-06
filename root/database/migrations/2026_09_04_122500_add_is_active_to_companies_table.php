<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddIsActiveToCompaniesTable extends Migration
{
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'is_active')) {
                $table->tinyInteger('is_active')->default(1)->after('id');
            }
        });

        if (Schema::hasColumn('companies', 'is_active')) {
            DB::table('companies')->whereNull('is_active')->update(['is_active' => 1]);
            DB::table('companies')->where('is_active', '!=', 0)->where('is_active', '!=', 1)->update(['is_active' => 1]);
        }
    }

    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
}
