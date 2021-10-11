<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryInOutsTable extends Migration
{
    public function up()
    {
        Schema::create('inventory_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_inventory_id')->constrained('material_inventories');
//            $table->foreignId('material_variation_id')->nullable()->constrained('material_variations');
            $table->foreignId('invoice_id')->nullable()->constrained('material_invoices');
//            $table->foreignId('factory_id')->nullable()->constrained('factories');
            $table->float('quantity');
            $table->float('price');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_in_outs');
    }
}
