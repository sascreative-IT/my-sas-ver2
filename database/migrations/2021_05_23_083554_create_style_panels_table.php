<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStylePanelsTable extends Migration
{
    public function up()
    {
        Schema::create('style_panels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('style_id')->constrained('styles');
            $table->foreignId('default_fabric_id')->nullable()->constrained('materials');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('style_panels');
    }
}
