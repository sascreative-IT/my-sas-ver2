<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->string('type')->primary();
            $table->string('name');

        });

        // Create units here self
        DB::insert('insert into units (type, name) values (?, ?)', ['cm', 'Centimeters']);
        DB::insert('insert into units (type, name) values (?, ?)', ['m', 'Meters']);
        DB::insert('insert into units (type, name) values (?, ?)', ['pcs', 'Pieces']);
        DB::insert('insert into units (type, name) values (?, ?)', ['yd', 'Yards']);
        DB::insert('insert into units (type, name) values (?, ?)', ['inc', 'Inches']);

    }

    public function down()
    {
        Schema::dropIfExists('units');
    }
}
