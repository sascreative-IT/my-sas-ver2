<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryStyleTable extends Migration
{
    public function up()
    {
        Schema::create('category_style', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('style_id')->constrained('styles');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_style');
    }
}
