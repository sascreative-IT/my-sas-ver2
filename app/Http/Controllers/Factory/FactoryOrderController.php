<?php

namespace App\Http\Controllers\Factory;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Factory;
use App\Models\InventoryReserv;
use App\Models\MaterialInventory;
use App\Models\Materials;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemPanel;
use App\Models\OrderItemSize;
use App\Models\Style;
use App\Models\StylePanelConsumption;
use App\Models\StylePanelFabric;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\StyleCodeRepositoryInterface as StyleCodeRepository;
use App\Repositories\OrderRepositoryInterface as OrderRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FactoryOrderController extends Controller
{
    protected $styleCodeRepository;
    protected $orderRepository;

    public function __construct(StyleCodeRepository $styleCodeRepository, OrderRepository $orderRepository)
    {
        $this->styleCodeRepository = $styleCodeRepository;
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $orders = Order::query()->latest('created_at')->get();

        return Inertia::render('Factory/FactoryOrderIndex', ['orders' => $orders]);
    }

    public function create(Request $request)
    {
        $order = new Order();

        $factories = Factory::query()
            ->with('country')
            ->get();

        $customers = Customer::query()
            ->select('id','name','cs_agent_id','sales_agent_id')
            ->get();

        $users = User::query()->get();

        $styleDetails = null;
        $styleFabrics = [];

        if ($request->filled('style_id')) {
            $styleDetails = $this->styleCodeRepository->getRelationsForStyle($request->get('style_id'));
            $styleFabrics = $this->styleCodeRepository->getFabricsForStyle($request->get('style_id'));
        }

        if ($request->filled('factory_id')) {
            $styles = $this->styleCodeRepository->getStyleCodesOfFactory($request->get('factory_id'));
        } else {
            $styles = $this->styleCodeRepository->getAll();
        }

        return Inertia::render('Factory/FactoryOrderCreate',
            [
                'form' => $order,
                'styles' => $styles,
                'categories' => Category::query()->select(['id', 'name'])->get(),
                'factories' => $factories,
                'customers' => $customers,
                'customer-service-agents' => $users,
                'selected-style-details' => $styleDetails,
                'selected-style-fabrics' => $styleFabrics ? $styleFabrics->first() : null,
            ]
        );
    }

    public function store(Request $request)
    {
//        $order = Order::create([
//            'public_id' => 'SAS ' . random_int(100, 1000),
//            'factory_id' => $request->input('factory.id'),
//            'type' => 'direct',
//            'production_requirement' => 'make',
//            'customer_id' => Customer::find(1)->id,
//            'sale_made_by_id' => User::find(1)->id,
//            'customer_service_by_id' => User::find(1)->id,
//        ]);

        $order = [
            'public_id' => 'SAS ' . random_int(100, 1000),
            'factory_id' => $request->input('factory.id'),
            'type' => 'direct',
            'production_requirement' => 'make',
            'customer_id' => $request->input('customer.id'),
            'sale_made_by_id' => $request->input('sale_made_by.id.id'),
            'customer_service_by_id' => $request->input('customer_service_by.id.id'),
        ];

        // move to action...
        $createdOrder = $this->orderRepository->createOrder($order);

        foreach ($request->input('items') as $item) {

            $orderItem = $this->orderRepository->createOrderItem([
                'order_id' => $createdOrder->id,
                'style_id' => $item['style']['id'],
                'production_type' => 'cut-and-saw',
                'price' => $item['price']
            ]);

            foreach ($item['sizes'] as $size) {

                $orderItemSize = $this->orderRepository->createOrderItemSize([
                    'order_item_id' => $orderItem->id,
                    'size_id' => $size['id'],
                    'quantity' => $size['quantity'],
                    'unit_price' => $size['price'],
                    'total_price' => $size['price'],
                ], $orderItem);

            }

            foreach ($item['panels'] as $panel) {
                $this->orderRepository->createOrderItemPanel([
                    'panel_id' => $panel['id'],
                    'fabric_id' => $panel['fabric']['id'],
                    'fabric_variation_id' => $panel['fabric_variation'] ?? null,
                ],$orderItem);

                $sizeIds = collect($item['sizes'])->pluck('id');
                $toReduce = StylePanelConsumption::query()
                    ->where('style_panel_id', $panel['id'])
                    ->whereIn('size_id', $sizeIds->toArray())
                    ->sum('amount');

                $inventory = MaterialInventory::query()
                    ->where('material_variation_id', $panel['fabric_variation'])
                    ->where('factory_id', $request->input('factory.id'))
                    ->get();

                $inventory = $inventory->first();

                InventoryReserv::create([
                    'material_inventory_id' => $inventory->id,
                    'order_id' => $order->id,
                    'quantity' => $toReduce
                ]);

                $inventory->refresh()->update([
                    'allocated_quantity' => ($inventory->allocated_quantity + $toReduce),
                ]);

                $inventory->refresh()->update([
                    'usable_quantity' => ($inventory->available_quantity - $inventory->allocated_quantity),
                ]);
            }
        }

        event(new OrderCreated($order));
        return redirect()->to('/factory');
    }

    public function show(Request $request)
    {
        return Inertia::render('Factory/FactoryOrderShow');
    }
}
