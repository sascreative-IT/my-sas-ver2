<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSizeStyleTable extends Migration
{
    public function up()
    {
        Schema::create('size_style', function (Blueprint $table) {
            $table->id();
            $table->foreignId('style_id')->constrained('styles');
            $table->foreignId('size_id')->constrained('sizes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('size_style');
    }
}
