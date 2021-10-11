<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemSizesTable extends Migration
{
    public function up()
    {
        Schema::create('order_item_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained('order_items');
            $table->foreignId('size_id')->constrained('sizes');
            $table->bigInteger('quantity');
            $table->decimal('unit_price', 12);
            $table->decimal('total_price', 12);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_item_sizes');
    }
}
