<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeCustomerContactTypeValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE customer_contacts MODIFY type ENUM('Primary', 'Other') NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE customer_contacts MODIFY type ENUM('sport','school-uniform', 'school-sport', 'corporate') NOT NULL");
    }
}
