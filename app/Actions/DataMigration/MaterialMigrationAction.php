<?php

namespace App\Actions\DataMigration;

use App\Models\Country;
use App\Models\MySas\Factory;
use App\Models\MySas\Material;
use App\Models\MySas\MaterialType;
use App\Models\MySas\MaterialUnit;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\DB;

class MaterialMigrationAction
{
    public function execute()
    {
        $output = new ConsoleOutput();

        $mysasMaterials = Material::all();
        $progress = new ProgressBar($output, Material::count());
        $progress->start();

        $total_records_migrated = DB::transaction(function () use ($mysasMaterials, $progress) {
            $total_records_migrated = 0;
            foreach ($mysasMaterials as $mysasMaterial) {

                $mysasMaterialType = MaterialType::find($mysasMaterial->material_type_id);
                $materialType = \App\Models\MaterialType::where('name',
                    $mysasMaterialType->material_type_name)->first();

                if (!$materialType) {
                    $materialType = \App\Models\MaterialType::create(
                        [
                            'type' => Str::slug($mysasMaterialType->material_type_name),
                            'name' => $mysasMaterialType->material_type_name,
                        ]
                    );
                }

                $mysasMaterialUnit = MaterialUnit::find($mysasMaterial->material_unit_id);
                $materialUnit = \App\Models\Unit::where('name', $mysasMaterialUnit->unit_name)->first();
                if (!$materialUnit) {
                    $materialUnit = \App\Models\Unit::create(
                        [
                            'type' => Str::slug($mysasMaterialUnit->unit_metric),
                            'name' => $mysasMaterialUnit->unit_name,
                        ]
                    );
                }


                $material = \App\Models\Materials::where('name', $mysasMaterial->material_name)
                    ->where('type', $materialType->type)
                    ->where('unit', $materialUnit->type)
                    ->first();
                if (!$material) {
                    \App\Models\Materials::create([
                        'name' => $mysasMaterial->material_name,
                        'fiber_content' => $mysasMaterial->fiber_content,
                        'type' => $materialType->type,
                        'unit' => $materialUnit->type,
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
