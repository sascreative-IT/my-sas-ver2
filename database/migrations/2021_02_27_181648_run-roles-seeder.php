<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RunRolesSeeder extends Migration
{
    public function up()
    {
        (new \Database\Seeders\PermissionsSeeder())->run();
    }

    public function down()
    {
        // nope
    }
}
