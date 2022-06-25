<?php

use App\Models\MaterialInventory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_inventories', function (Blueprint $table) {
            $table->uuid('aggregate_id')->unique()->after('id')->nullable();
        });

        foreach (MaterialInventory::query()->whereNull('aggregate_id')->cursor() as $inventory) {
            $inventory->update(['aggregate_id' => Str::uuid()->toString()]);
        }

        Schema::table('material_inventories', function (Blueprint $table) {
            $table->uuid('aggregate_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('material_inventories', function (Blueprint $table) {
            $table->dropColumn('aggregate_id');
        });
    }
};
