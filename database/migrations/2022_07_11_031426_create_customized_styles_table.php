<?php

use App\Models\Style;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('customized_styles', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->integer('production_time')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->foreignId('parent_style_id')->nullable()->constrained('styles');
            $table->foreignId('item_type_id')->nullable()->constrained('item_types');
            $table->longText('description')->nullable();
            $table->string('style_image')->nullable();
            $table->enum('belongs_to', ['internal', 'external']);
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customized_styles');
    }
};
