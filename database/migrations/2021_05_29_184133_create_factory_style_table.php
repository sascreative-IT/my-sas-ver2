<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoryStyleTable extends Migration
{
    public function up()
    {
        Schema::create('factory_style', function (Blueprint $table) {
            $table->id();
            $table->foreignId('style_id')->constrained('styles');
            $table->foreignId('factory_id')->constrained('factories');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('factory_style');
    }
}
