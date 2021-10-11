<?php
declare(strict_types=1);

namespace Tests\Feature\Domains\Styles\Actions;

use App\Domains\Styles\Actions\AttachPanelToStyle;
use App\Domains\Styles\Actions\AttachSizeToStyle;
use App\Domains\Styles\Dto\Panel;
use App\Models\Materials;
use App\Models\Size;
use App\Models\Style;
use App\Models\StylePanel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttachPanelToStyleTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_saves_panel(): void
    {
        $style = Style::factory()->create();
        $fabric1 = Materials::factory()->create(['type' => 'fabric']);
        $fabric2 = Materials::factory()->create(['type' => 'fabric']);
        $size1 = Size::factory()->create();
        $size2 = Size::factory()->create();

        $panel = new Panel([
            'name' => 'Panel 1',
            'fabrics' => [
                ['id' => $fabric1->id],
                ['id' => $fabric2->id],
            ],
            'default_fabric' => ['id' => $fabric1->id],
            'consumption' => [
                [
                    'size' => ['id' => $size1->id],
                    'amount' => 20
                ],
                [
                    'size' => ['id' => $size2->id],
                    'amount' => 10
                ],
            ]
        ]);

        $this->assertCount(0, StylePanel::all());

        resolve(AttachPanelToStyle::class)->execute($style, $panel);

        $this->assertCount(1, StylePanel::all());
    }
}
