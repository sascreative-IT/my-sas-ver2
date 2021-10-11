<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddUserDeactivateColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('erp_user_details', function($table) {
            $table->dateTime('deactivated_at')->nullable()->after('contact_number');
            $table->foreignId('deactivated_by')->nullable()->after('contact_number')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('erp_user_details', function($table) {
            $table->dropColumn('deactivated_at');
            $table->dropColumn('deactivated_by');
        });
    }
}
