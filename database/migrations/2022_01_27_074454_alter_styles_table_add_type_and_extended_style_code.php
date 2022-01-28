<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStylesTableAddTypeAndExtendedStyleCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('styles', function (Blueprint $table) {
            $table->dropForeign('styles_type_id_foreign');
            $table->string('styles_type')->after('name')->nullable();
            $table->string('style_image')->after('description')->nullable();
            $table->renameColumn('type_id', 'item_type_id');
        });

        Schema::table('styles', function (Blueprint $table) {
            $table->foreignId('parent_style_id')
                ->after('customer_id')
                ->nullable()
                ->constrained('styles');

            $table->foreign('item_type_id')
                ->references('id')
                ->on('item_types')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('styles', function (Blueprint $table) {
            $table->renameColumn('item_type_id', 'type_id');
            $table->dropColumn('styles_type');
            $table->dropColumn('style_image');
        });

        Schema::table('styles', function (Blueprint $table) {
            $table->foreign('type_id')
                ->references('id')
                ->on('item_types')
                ->onDelete('cascade');

            $table->dropForeign('styles_item_type_id_foreign');
            $table->dropForeign('styles_parent_style_id_foreign');
            $table->dropColumn('parent_style_id');
        });
    }
}
