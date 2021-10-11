<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialInvoiceItemsTable extends Migration
{
    public function up()
    {
        Schema::create('material_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_invoice_id')->constrained('material_invoices');
            $table->foreignId('material_variation_id')->constrained('material_variations');
            $table->float('quantity');
            $table->string('unit');
            $table->float('price');
            $table->string('currency');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_invoice_items');
    }
}
