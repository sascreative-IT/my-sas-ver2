<?php
declare(strict_types=1);

namespace Tests\Feature\Domains\Styles\Actions;

use App\Domains\Styles\Actions\AttachSizeToStyle;
use App\Domains\Styles\Dto\Size as SizeDto;
use App\Models\Size;
use App\Models\Style;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttachSizeToStyleTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_style_sizes(): void
    {
        $style = Style::factory()->create();
        $size = Size::factory()->create();

        $this->assertCount(0, $style->sizes);

        (new AttachSizeToStyle())->execute($style, new SizeDto($size->toArray()));

        $this->assertCount(1, $style->refresh()->sizes);
        $this->assertEquals($size->id, $style->sizes->first()->id);
    }

    public function test_it_doesnt_make_duplicate_style_sizes(): void
    {
        /** @var Style $style */
        $style = Style::factory()->create();
        $size = Size::factory()->create();

        $style->sizes()->attach($size);

        $this->assertCount(1, $style->refresh()->sizes);

        (new AttachSizeToStyle())->execute($style, new SizeDto($size->toArray()));

        $this->assertCount(1, $style->refresh()->sizes);
        $this->assertEquals($size->id, $style->sizes->first()->id);
    }
}
