<?php

namespace App\Actions\DataMigration;

use App\Models\Country;
use App\Models\MySas\Factory;
use App\Models\MySas\Warehouse;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\DB;

class WarehouseMigrationAction
{
    public function execute()
    {
        $output = new ConsoleOutput();

        $mysasWarehouses = Warehouse::all();
        $progress = new ProgressBar($output, Factory::count());
        $progress->start();

        $total_records_migrated = DB::transaction(function () use ($mysasWarehouses, $progress) {
            $total_records_migrated = 0;
            foreach ($mysasWarehouses as $mysasWarehouse) {

                $country = Country::where('name', $mysasWarehouse->country)->first();
                if (!$country) {
                    $country = Country::create(
                        [
                            'name' => $mysasWarehouse->country,
                            'sort' => substr($mysasWarehouse->country, 0, 2),
                        ]
                    );
                }

                $warehouse = \App\Models\Warehouse::where('name', $mysasWarehouse->name)
                    ->where('country_id', $country->id)
                    ->first();
                if (!$warehouse) {
                    \App\Models\Warehouse::create([
                        'name' => $mysasWarehouse->name,
                        'country_id' => $country->id
                    ]);
                    $total_records_migrated++;
                }

                $progress->advance();
            }

            return $total_records_migrated;
        });


        $progress->finish();
        return $total_records_migrated;
    }
}
