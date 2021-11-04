<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOutItemsTable extends Migration
{
    public function up()
    {
        Schema::create('stock_out_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_out_id')->constrained('stock_outs');
            $table->foreignId('style_id')->constrained('styles');
            $table->foreignId('style_panel_id')->constrained('style_panels');
            $table->foreignId('material_id')->constrained('materials');
            $table->foreignId('colour_id')->constrained('colours');
            $table->decimal('pieces')->default(0);
            $table->decimal('usage')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_out_items');
    }
}
