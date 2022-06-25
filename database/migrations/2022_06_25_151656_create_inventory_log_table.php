<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('material_inventories_aggregate_id');
            $table->string('unit');
            $table->float('in')->nullable();
            $table->float('out')->nullable();
            $table->float('balance');
            $table->foreignId('in_invoice_item_id')->nullable()->constrained('material_invoice_items');
            $table->float('in_unit_price')->nullable();
            $table->string('in_unit_currency')->nullable();
            $table->float('out_order_id')->nullable();
            $table->float('out_style_panel_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_log');
    }
};
