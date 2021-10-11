<?php
declare(strict_types=1);

namespace Database\Seeders;


use App\Models\ItemType;
use Illuminate\Database\Seeder;

class ItemTypeSeeder extends Seeder
{
    public function run()
    {
        $types = collect([
            'T-SHIRT/ POLO',
            'LONG SLEEVE T-SHIRT/POLO',
            'HOODIE (CVC FLEECE)',
            'POLYESTER JACKET',
            'HOODIE SLEEVELESS (CVC FLEECE)',
            'TRACK JACKET',
            'TRACK PANT',
            'SINGLET',
            'POLYESTER CARGO SHORT',
        ]);


        $types->each(function ($type) {
            ItemType::factory()->create([
                'name' => $type
            ]);
        });
    }
}
