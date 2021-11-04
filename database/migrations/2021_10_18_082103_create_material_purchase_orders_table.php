<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Domains\PurchaseOrder\State\MaterialPurchaseOrderState;

class CreateMaterialPurchaseOrdersTable extends Migration
{

    public function up()
    {
        Schema::create('material_purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->enum('evaluation_status', ['Pending','Approved','Rejected'])->default("Pending");
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('factory_id')->constrained('factories');
            $table->foreignId('evaluated_by')->nullable()->constrained('users');
            $table->timestamp('evaluated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Schema::dropIfExists('material_purchase_orders');
    }
}
