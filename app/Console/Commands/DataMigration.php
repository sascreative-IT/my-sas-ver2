<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class DataMigration extends Command
{

    protected $signature = 'mysas:data-migration';


    protected $description = 'The command is to migrate data from OLD MYSAS to NEW MYSAS';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $migrationOption = $this->choice(
            'Which data, do you want to get migrated?',
            [
                'Factories',
                'Warehouses',
                'Colors',
                'Materials'
            ]
        );


        $this->info("You had chosen " . $migrationOption . " to migrate");
        if ($this->confirm('Do you wish to continue?')) {


            $actionClass = "App\\Actions\\DataMigration\\".Str::singular($migrationOption)."MigrationAction";

            if (!class_exists($actionClass)) {
                $this->error("Unable to load the action class for $migrationOption");
                return false;
            }

            $this->info("Migration started....\n");
            $res = (new $actionClass)->execute();
            $this->info("\n");
            $this->info("Total records migrated: ".$res);
            $this->info("Migration completed.");

        }

    }
}
