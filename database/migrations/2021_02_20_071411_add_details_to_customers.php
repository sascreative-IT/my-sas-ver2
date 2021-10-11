<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('name',255);
            $table->string('email',255);
            $table->text('description');
            $table->foreignId('cs_agent_id')->nullable()->constrained('users');
            $table->foreignId('sales_agent_id')->nullable()->constrained('users');
            $table->foreignId('logo_id')->nullable()->constrained('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            Schema::dropIfExists('customers');
        });
    }
}
