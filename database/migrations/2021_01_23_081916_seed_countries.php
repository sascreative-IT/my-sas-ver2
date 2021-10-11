<?php

use Database\Seeders\CountrySeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

class SeedCountries extends Migration
{
    public function up()
    {
        Artisan::call('db:seed', ['--class' => CountrySeeder::class , '--force' => true]);
    }


    public function down()
    {
        // go going back
    }
}
