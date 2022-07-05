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
        Schema::table('stock_outs', function (Blueprint $table) {
            $table->dropForeign('stock_outs_order_id_foreign');
            $table->dropColumn('order_id');
        });
        Schema::table('stock_outs', function (Blueprint $table) {
            $table->string('order_id')->nullable()->index()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_outs', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
        Schema::table('stock_outs', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained('orders')->after('id');
        });
    }
};
