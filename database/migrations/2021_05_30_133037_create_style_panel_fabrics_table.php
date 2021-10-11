<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStylePanelFabricsTable extends Migration
{
    public function up()
    {
        Schema::create('style_panel_fabrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('style_panel_id')->constrained('style_panels');
            $table->foreignId('material_id')->constrained('materials');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('style_panel_fabrics');
    }
}
