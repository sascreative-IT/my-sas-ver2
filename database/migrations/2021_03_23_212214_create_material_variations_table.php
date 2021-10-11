<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialVariationsTable extends Migration
{
    public function up()
    {
        Schema::create('material_variations', function (Blueprint $table) {
            $table->id();
//            $table->string('name')->nullable();
            $table->foreignId('material_id')->constrained('materials');
            $table->foreignId('colour_id')->constrained('colours');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_variations');
    }
}
