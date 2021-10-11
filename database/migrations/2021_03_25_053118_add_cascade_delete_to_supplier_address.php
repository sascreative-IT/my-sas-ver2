<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeDeleteToSupplierAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplier_addresses', function (Blueprint $table) {
            $table->dropForeign('supplier_addresses_supplier_id_foreign');
            $table->dropForeign('supplier_addresses_address_id_foreign');

            $table->foreignId('supplier_id')
                ->change()
                ->constrained('suppliers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('address_id')
                ->change()
                ->constrained('addresses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
