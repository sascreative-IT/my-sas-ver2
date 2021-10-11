<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('public_id');
            $table->foreignId('factory_id')->constrained('factories');
            $table->enum('type', ['direct', 'retail', 'sample', 'stock']);
            $table->enum('production_requirement', ['make', 'pickup']);
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('sale_made_by_id')->constrained('users');
            $table->foreignId('customer_service_by_id')->constrained('users');
            $table->string('team_clubs_school')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
