<?php
declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Factory;
use App\Models\Size;
use App\Models\Style;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StyleTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_relationship(): void
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        /** @var Style $style */
        $style = Style::factory()->create();

        $style->categories()->attach([$category1->id, $category2->id]);

        $this->assertEquals($category1->id, $style->categories->first()->id);
        $this->assertEquals($category2->id, $style->categories->last()->id);
    }

    public function test_sizes_relationship(): void
    {
        $size1 = Size::factory()->create();
        $size2 = Size::factory()->create();

        /** @var Style $style */
        $style = Style::factory()->create();

        $style->sizes()->attach([$size1->id, $size2->id]);

        $this->assertEquals($size1->id, $style->sizes->first()->id);
        $this->assertEquals($size2->id, $style->sizes->last()->id);
    }

    public function test_factories_relationship(): void
    {
        $factory1 = Factory::factory()->create();
        $factory2 = Factory::factory()->create();

        /** @var Style $style */
        $style = Style::factory()->create();

        $style->factories()->attach([$factory1->id, $factory2->id]);

        $this->assertEquals($factory1->id, $style->factories->first()->id);
        $this->assertEquals($factory2->id, $style->factories->last()->id);
    }
}
