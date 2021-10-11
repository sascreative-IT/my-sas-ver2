<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialSuppliersTable extends Migration
{
    public function up()
    {
        Schema::create('material_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variation_id')->constrained('material_variations');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('factory_id')->constrained('factories');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_suppliers');
    }
}
