<?php
declare(strict_types=1);

namespace Tests\Feature\Domains\Styles\Actions;

use App\Domains\Styles\Actions\AttachCategoryToStyle;
use App\Domains\Styles\Actions\AttachFactoriesToStyle;
use App\Domains\Styles\Actions\AttachSizeToStyle;
use App\Domains\Styles\Actions\CreateStyle;
use App\Domains\Styles\Dto\Style;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Factory;
use App\Models\ItemType;
use App\Models\Size;
use GuzzleHttp\Promise\Create;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class CreateStyleTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_style_code()
    {
        $category = Category::factory()->create();
        $type = ItemType::factory(['name' => 'type 1'])->create();
        $factories = Factory::factory()->count(2)->create();
        $customer = Customer::factory()->create();

        $style = new Style([
            'belongs_to' => 'internal',
            'code' => '001',
            'name' => 'Style 001',
            'description' => 'test',
            'customer' => $customer->toArray(),
            'categories' => [$category->toArray()],
            'type' => $type->toArray(),
            'production_time' => 60,
            'sizes' => Size::factory()->count(2)->create()->toArray(),
            'factories' => $factories->toArray(),
            'status' => 'draft'
        ]);

        $attachSizeToStyleMockedAction = $this->mock(AttachSizeToStyle::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')->times(2);
        });

        $attachCategoryToStyleMockedAction = $this->mock(AttachCategoryToStyle::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')->times(1);
        });

        $attachFactoriesToStyleMockedAction = $this->mock(AttachFactoriesToStyle::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')->times(2);
        });

        (new CreateStyle(
            $attachSizeToStyleMockedAction,
            $attachCategoryToStyleMockedAction,
            $attachFactoriesToStyleMockedAction
        ))->execute($style);

        $style = \App\Models\Style::query()->where('code', '001')->first();

        $this->assertEquals('001', $style->code);
        $this->assertEquals('Style 001', $style->name);
        $this->assertEquals($type->id, $style->type_id);
        $this->assertEquals('test', $style->description);
        $this->assertEquals($customer->id, $style->customer_id);
        $this->assertEquals('internal', $style->belongs_to);
        $this->assertEquals('draft', $style->status);
        $this->assertNotEmpty($style->created_at);
        $this->assertNotEmpty($style->updated_at);
    }
}
