<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStylePanelConsumption extends Migration
{
    public function up()
    {
        Schema::create('style_panel_consumptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('style_panel_id')->constrained('style_panels');
            $table->foreignId('size_id')->constrained('sizes');
            $table->float('amount', 10, 2);
            $table->string('unit');
            $table->timestamps();

            $table->foreign('unit')
                ->references('type')
                ->on('units')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('style_panel_consumptions');
    }
}
