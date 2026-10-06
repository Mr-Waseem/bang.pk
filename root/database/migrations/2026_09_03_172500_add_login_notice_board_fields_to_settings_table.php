<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddLoginNoticeBoardFieldsToSettingsTable extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'login_note_title')) {
                $table->string('login_note_title', 191)->nullable();
            }
            if (!Schema::hasColumn('settings', 'login_note_body')) {
                $table->text('login_note_body')->nullable();
            }
        });

        $exists = DB::table('settings')->where('id', 1)->exists();
        if ($exists) {
            $current = DB::table('settings')->where('id', 1)->first();
            $updates = [];
            if (empty($current->login_note_title)) {
                $updates['login_note_title'] = 'Notice Board';
            }
            if (empty($current->login_note_body)) {
                $updates['login_note_body'] = "Stay informed about FBR Digital Invoicing updates and system notices.\n\n- Keep your NTN and token details up to date\n- Contact support for new company registration\n- Call 0321 4197290 for POS / Digital Invoicing help";
            }
            if (!empty($updates)) {
                DB::table('settings')->where('id', 1)->update($updates);
            }
        }
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'login_note_body')) {
                $table->dropColumn('login_note_body');
            }
            if (Schema::hasColumn('settings', 'login_note_title')) {
                $table->dropColumn('login_note_title');
            }
        });
    }
}
