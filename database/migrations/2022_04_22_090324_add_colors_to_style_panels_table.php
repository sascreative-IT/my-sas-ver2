<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorsToStylePanelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('style_panels', function (Blueprint $table) {
            $table->foreignId('color_id')->nullable()->constrained('colours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('style_panels', function (Blueprint $table) {
            $table->dropColumn('color_id');
        });
    }
}
