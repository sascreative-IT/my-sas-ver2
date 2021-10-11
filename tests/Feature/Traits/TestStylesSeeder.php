<?php
declare(strict_types=1);

namespace Tests\Feature\Traits;

use Illuminate\Database\Eloquent\Model;
use App\Models\Style;
use Illuminate\Support\Arr;

trait TestStylesSeeder
{
    public function seedStyle(Model $factory, array $sizes, $category, $itemType, $customer) : Style
    {
        /** @var Style $style */
        $style = Style::factory()->create([
            'code' => 'TOP 222SW FB SCP',
            'name' => 'Women\'s Sublimated Training Singlet (TOP 222SW FB SCP)',
            'type_id' => $itemType->id,
            'customer_id' => $customer->id,
            'production_time' => 120,
            'belongs_to' => Style::INTERNAL,
        ]);

        $style->factories()->syncWithoutDetaching($factory->id);
        $style->categories()->syncWithoutDetaching($category->id);
        $style->sizes()->syncWithoutDetaching(Arr::pluck($sizes, 'id'));

        return $style;
    }

    public function seedStylePanelDetails(Model $material, Model $stylePanel)
    {
        $stylePanel->fabrics()->syncWithoutDetaching($material->id);

        return $stylePanel;
    }
}
