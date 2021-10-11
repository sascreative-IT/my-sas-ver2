<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('fiber_content')->nullable();
            $table->string('type');
            $table->string('unit');
            $table->timestamps();

            $table->foreign('unit')
                ->references('type')
                ->on('units')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('type')
                ->references('type')
                ->on('material_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
