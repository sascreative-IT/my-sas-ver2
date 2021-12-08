<?php

namespace App\Actions\DataMigration;


use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\DB;

class ColorMigrationAction
{
    public function execute()
    {
        $output = new ConsoleOutput();

        $mysasColors = \App\Models\MySas\Color::all();
        $progress = new ProgressBar($output, \App\Models\MySas\Color::count());
        $progress->start();

        $total_records_migrated = DB::transaction(function () use ($mysasColors, $progress) {
            $total_records_migrated = 0;
            foreach ($mysasColors as $mysasColor) {
                $color = \App\Models\Colour::where('name', $mysasColor->title)
                    ->first();

                if (!$color) {
                    if ($mysasColor->title) {
                        \App\Models\Colour::create([
                            'name' => $mysasColor->title,
                            'type' => 'fabric',
                            'is_active' => 1
                        ]);
                        $total_records_migrated++;
                    }
                }

                $progress->advance();
            }
            return $total_records_migrated;
        });

        $progress->finish();

        return $total_records_migrated;
    }
}
