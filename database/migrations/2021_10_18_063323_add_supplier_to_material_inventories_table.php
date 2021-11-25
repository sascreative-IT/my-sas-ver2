<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupplierToMaterialInventoriesTable extends Migration
{
    public function up()
    {
        Schema::table('material_inventories', function (Blueprint $table) {
            $table->foreignId('supplier_id')
                ->nullable()
                ->after("factory_id")
                ->constrained('suppliers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table('material_inventories', function (Blueprint $table) {
            $table->dropForeign('material_inventories_supplier_id_foreign');
            $table->dropIndex('material_inventories_supplier_id_foreign');
            $table->dropColumn('supplier_id');
        });
    }
}
