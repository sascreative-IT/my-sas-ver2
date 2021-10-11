<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMaterialTypesTable extends Migration
{
    public function up()
    {
        Schema::create('material_types', function (Blueprint $table) {
            $table->string('type')->primary();
            $table->string('name');
        });

        // creating non changing items here it self
        DB::insert('insert into material_types (type, name) values (?, ?)', ['fabric', 'Fabric']);
        DB::insert('insert into material_types (type, name) values (?, ?)', ['accessories_trims', 'Accessories/Trims']);
    }

    public function down()
    {
        Schema::dropIfExists('material_types');
    }
}
