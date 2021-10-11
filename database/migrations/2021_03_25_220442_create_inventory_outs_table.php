<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryOutsTable extends Migration
{
    public function up()
    {
        Schema::create('inventory_outs', function (Blueprint $table) {
            $table->id();
            // todos
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_outs');
    }
}
