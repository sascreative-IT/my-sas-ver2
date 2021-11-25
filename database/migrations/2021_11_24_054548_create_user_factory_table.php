<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFactoryTable extends Migration
{
    public function up()
    {
        Schema::create('user_factory', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('factory_id')->constrained('factories');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_factory');
    }
}
