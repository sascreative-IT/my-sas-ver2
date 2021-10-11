<?php
declare(strict_types=1);

namespace Tests\Feature\Domains\Styles\Actions;

use App\Domains\Styles\Actions\AttachCategoryToStyle;
use App\Domains\Styles\Dto\Category as CategoryDto;
use App\Models\Category;
use App\Models\Style;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttachCategoryToStyleTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_gets_attached_to_style(): void
    {
        /** @var Style $style */
        $style = Style::factory()->create();
        $category = Category::factory()->create();

        $this->assertCount(0, $style->categories);

        (new AttachCategoryToStyle())->execute($style, new CategoryDto($category->toArray()));

        $this->assertCount(1, $style->refresh()->categories);
        $this->assertEquals($category->id, $style->refresh()->categories->first()->id);
    }

    public function test_it_doesnt_make_duplicate_style_categories(): void
    {
        /** @var Style $style */
        $style = Style::factory()->create();
        $category = Category::factory()->create();

        $style->categories()->attach($category);

        $this->assertCount(1, $style->refresh()->categories);

        (new AttachCategoryToStyle())->execute($style, new CategoryDto($category->toArray()));

        $this->assertCount(1, $style->refresh()->categories);
        $this->assertEquals($category->id, $style->refresh()->categories->first()->id);
    }
}
