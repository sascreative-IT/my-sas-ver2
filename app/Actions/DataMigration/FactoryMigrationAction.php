<?php

namespace App\Actions\DataMigration;

use App\Models\Country;
use App\Models\MySas\Factory;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\DB;

class FactoryMigrationAction
{
    public function execute()
    {
        $output = new ConsoleOutput();

        $mysasFactories = Factory::all();
        $progress = new ProgressBar($output, Factory::count());
        $progress->start();

        $total_records_migrated = DB::transaction(function () use ($mysasFactories, $progress) {
            $total_records_migrated = 0;
            foreach ($mysasFactories as $mysasFactory) {

                $country = Country::where('name', $mysasFactory->country)->first();
                if (!$country) {
                    $country = Country::create(
                        [
                            'name' => $mysasFactory->country,
                            'sort' => $mysasFactory->location
                        ]
                    );
                }

                $factory = \App\Models\Factory::where('name', $mysasFactory->name)
                    ->where('country_id', $country->id)
                    ->first();
                if (!$factory) {
                    \App\Models\Factory::create([
                        'name' => $mysasFactory->name,
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
