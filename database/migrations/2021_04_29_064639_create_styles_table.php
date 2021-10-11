<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStylesTable extends Migration
{
    public function up()
    {
        Schema::create('styles', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->integer('production_time')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->foreignId('type_id')->constrained('item_types');
            $table->longText('description')->nullable();
            $table->enum('belongs_to', ['internal', 'external']);
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('styles');
    }
}
