<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('material_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->string('purchase_order_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->foreignId('factory_id')->constrained('factories');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_invoices');
    }
}
