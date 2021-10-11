<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialInventoriesTable extends Migration
{
    public function up()
    {
        Schema::create('material_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_variation_id')->constrained('material_variations');
            $table->string('unit');
            $table->float('available_quantity', 100, 2);
            $table->float('allocated_quantity',100, 2);
            $table->float('usable_quantity', 100, 2);
            $table->foreignId('factory_id')->constrained('factories');
            $table->timestamps();

            $table->foreign('unit')->references('type')->on('units');
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_inventories');
    }
}
