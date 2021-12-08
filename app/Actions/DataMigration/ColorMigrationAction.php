<?php

namespace App\Actions\DataMigration;


use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\DB;

class ColorMigrationAction
{
    public function execute()
    {
        $total_records_migrated = 0;
        $output = new ConsoleOutput();

        $mysasColors = \App\Models\MySas\Color::all();
        $progress = new ProgressBar($output, \App\Models\MySas\Color::count());
        $progress->start();

        DB::transaction(function () use ($mysasColors, $progress, $total_records_migrated) {
            foreach ($mysasColors as $mysasColor) {

                $color = \App\Models\Colour::where('name', $mysasColor->name)
                    ->first();
                if (!$color) {
                    if ($mysasColor->name) {
                        \App\Models\Colour::create([
                            'name' => $mysasColor->name
                        ]);
                        $total_records_migrated++;
                    }
                }
                $progress->advance();
            }
        });

        $progress->finish();

        return $total_records_migrated;
    }
}
