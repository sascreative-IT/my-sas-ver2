<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemPanelsTable extends Migration
{
    public function up()
    {
        Schema::create('order_item_panels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained('order_items');
            $table->foreignId('panel_id')->constrained('style_panels');
            $table->foreignId('fabric_id')->constrained('materials');
            $table->foreignId('fabric_variation_id')->nullable()->constrained('materials');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_item_panels');
    }
}
