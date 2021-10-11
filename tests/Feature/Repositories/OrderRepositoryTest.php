<?php


namespace Repositories;

use App\Models\Category;
use App\Models\Colour;
use App\Models\Customer;
use App\Models\Factory;
use App\Models\ItemType;
use App\Models\Materials;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Size;
use App\Models\StylePanel;
use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\Feature\Traits\TestStylesSeeder;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;
    use TestStylesSeeder;

    protected $orderRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderRepo = new OrderRepository;
    }


    public function test_it_create_the_order()
    {
        $sLFactory = Factory::factory()->create([
            'name' => 'SL Factory',
        ]);

        $user = User::factory()->create([
            'email' => 'testemail@email.com'
        ]);

        $customer = Customer::factory()->create();

        $order = [
            'public_id' => 'SAS 123',
            'factory_id' => $sLFactory->id,
            'type' => 'direct',
            'production_requirement' => 'make',
            'customer_id' => $customer->id,
            'sale_made_by_id' => $user->id,
            'customer_service_by_id' => $user->id,
        ];

        $dbOrder = $this->orderRepo->createOrder($order);
        $dbOrder = $dbOrder->getAttributes();
        $dbOrderFiltered = Arr::except($dbOrder, ['id','created_at','updated_at']);

        $this->assertDatabaseCount('orders', 1);
        $this->assertEquals($dbOrderFiltered, $order);
    }

    public function test_it_create_the_order_item()
    {
        $itemType = ItemType::factory()->create([
            'name' => 'T-SHIRT/ POLO'
        ]);

        $sLFactory = Factory::factory()->create([
            'name' => 'SL Factory',
        ]);

        $category = Category::firstOrCreate([
            'name' => 'Basketball'
        ]);
        $customer = Customer::factory()->create();
        $size1 = Size::firstOrCreate(['name' => 'S', 'slug' => 's']);
        $size2 = Size::firstOrCreate(['name' => 'M', 'slug' => 'm']);

        $style = $this->seedStyle($sLFactory, [$size1, $size2], $category, $itemType, $customer);

        $order = [
            'public_id' => 'SAS 123',
            'factory_id' => Factory::factory()->create()->id,
            'type' => 'direct',
            'production_requirement' => 'make',
            'customer_id' => Customer::factory()->create()->id,
            'sale_made_by_id' => User::factory()->create()->id,
            'customer_service_by_id' => User::factory()->create()->id,
        ];

        $dbOrder = $this->orderRepo->createOrder($order);

        $orderItem = [
            'order_id' => $dbOrder['id'],
            'style_id' => $style->id,
            'production_type' => 'cut-and-saw',
            'price' => 200
        ];

        $dbOrderItem = $this->orderRepo->createOrderItem($orderItem);

        $dbOrderItem = $dbOrderItem->getAttributes();
        $dbOrderItemFiltered = Arr::except($dbOrderItem, ['id','created_at','updated_at']);

        $this->assertDatabaseCount('order_items', 1);
        $this->assertEquals($dbOrderItemFiltered, $orderItem);
    }

    public function test_it_create_the_order_item_size()
    {
        $itemType = ItemType::factory()->create();
        $sLFactory = Factory::factory()->create();
        $category = Category::factory()->create();
        $customer = Customer::factory()->create();
        $size1 = Size::firstOrCreate(['name' => 'S', 'slug' => 's']);
        $size2 = Size::firstOrCreate(['name' => 'M', 'slug' => 'm']);
        $style = $this->seedStyle($sLFactory, [$size1, $size2], $category, $itemType, $customer);

        $order = Order::factory()->create();
        $orderItem = OrderItem::factory()->create([
            'order_id' => $order->id,
            'style_id' => $style->id
        ]);

        $orderItemSize = [
            'order_item_id' => $orderItem->id,
            'size_id' => $size1->id,
            'quantity' => 20,
            'unit_price' => 100,
        ];

        $dbOrderItemSize = $this->orderRepo->createOrderItemSize($orderItemSize, $orderItem);
        $dbOrderItemSize = $dbOrderItemSize->getAttributes();
        $dbOrderItemSizeFiltered = Arr::except($dbOrderItemSize, ['id','created_at','updated_at', 'total_price']);


        $this->assertDatabaseCount('order_item_sizes', 1);
        $this->assertEquals($dbOrderItemSizeFiltered, $orderItemSize);
        $this->assertEquals($orderItemSize['unit_price'] * $orderItemSize['quantity'],$dbOrderItemSize['total_price']);
    }

    public function test_it_create_the_order_item_panel()
    {
        $itemType = ItemType::factory()->create();
        $sLFactory = Factory::factory()->create();
        $category = Category::factory()->create();
        $customer = Customer::factory()->create();
        $size1 = Size::firstOrCreate(['name' => 'S', 'slug' => 's']);
        $size2 = Size::firstOrCreate(['name' => 'M', 'slug' => 'm']);

        $style = $this->seedStyle($sLFactory, [$size1, $size2], $category, $itemType, $customer);

        $order = Order::factory()->create();
        $orderItem = OrderItem::factory()->create([
            'order_id' => $order->id,
            'style_id' => $style->id
        ]);
        $material= Materials::factory()->create();
        $panel = StylePanel::factory()->create([
            'style_id' => $style->id,
            'default_fabric_id' => $material->id
        ]);
        $color = Colour::factory()->create();

        $orderItemPanel = [
            'order_item_id' => $orderItem->id,
            'panel_id' => $panel->id,
            'fabric_id' => $material->id,
            'fabric_variation_id' => $color->id,
        ];

        $dbOrderItemPanel = $this->orderRepo->createOrderItemPanel($orderItemPanel, $orderItem);
        $dbOrderItemPanelFiltered = Arr::except($dbOrderItemPanel, ['id','created_at','updated_at', 'total_price']);

        $this->assertDatabaseCount('order_item_panels', 1);
        $this->assertEquals($dbOrderItemPanelFiltered, $dbOrderItemPanel);
    }
}
