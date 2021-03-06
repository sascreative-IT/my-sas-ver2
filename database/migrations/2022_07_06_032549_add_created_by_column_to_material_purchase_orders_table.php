<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_purchase_orders', function (Blueprint $table) {
            $table->foreignId('created_by')->after('evaluated_by')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('material_purchase_orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
        });
    }
};
