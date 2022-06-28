<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOutsTable extends Migration
{

    public function up()
    {
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->foreignId('factory_id')->constrained('factories');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('created_by_id')->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_outs');
    }
}
