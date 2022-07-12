<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_customized_styles', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->integer('production_time')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->foreignId('item_type_id')->nullable()->constrained('item_types');
            $table->longText('description')->nullable();
            $table->string('style_image')->nullable();
            $table->enum('belongs_to', ['internal', 'external']);
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_customized_styles');
    }
};
