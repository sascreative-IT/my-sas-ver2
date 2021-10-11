<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryReservsTable extends Migration
{
    public function up()
    {
        Schema::create('inventory_reservs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_inventory_id')->constrained('material_inventories');
            $table->foreignId('order_id')->constrained('orders');
            $table->float('description')->nullable();
            $table->float('quantity');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_reservs');
    }
}
