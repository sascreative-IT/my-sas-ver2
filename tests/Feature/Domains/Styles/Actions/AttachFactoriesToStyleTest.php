<?php
declare(strict_types=1);

namespace Tests\Feature\Domains\Styles\Actions;


use App\Domains\Styles\Actions\AttachCategoryToStyle;
use App\Domains\Styles\Actions\AttachFactoriesToStyle;
use App\Domains\Styles\Dto\Factory as FactoryDto;
use App\Models\Category;
use App\Models\Factory;
use App\Models\Style;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\DataTransferObject\DataTransferObject as CategoryDto;
use Tests\TestCase;

class AttachFactoriesToStyleTest extends TestCase
{
    use RefreshDatabase;

    public function test_factories_gets_attached_to_style(): void
    {
        /** @var Style $style */
        $style = Style::factory()->create();
        $factory = Factory::factory()->create();

        $this->assertCount(0, $style->factories);

        (new AttachFactoriesToStyle())->execute($style, new FactoryDto($factory->toArray()));

        $this->assertCount(1, $style->refresh()->factories);
        $this->assertEquals($factory->id, $style->refresh()->factories->first()->id);
    }

    public function test_it_doesnt_make_duplicate_style_factories(): void
    {
        /** @var Style $style */
        $style = Style::factory()->create();
        $factory = Factory::factory()->create();

        $style->factories()->attach($factory);

        $this->assertCount(1, $style->refresh()->factories);

        (new AttachFactoriesToStyle())->execute($style, new FactoryDto($factory->toArray()));

        $this->assertCount(1, $style->refresh()->factories);
        $this->assertEquals($factory->id, $style->refresh()->factories->first()->id);
    }
}
