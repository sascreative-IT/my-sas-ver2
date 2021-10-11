<?php


namespace App\Repositories;


use App\Models\Customer;
use App\Models\Factory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemPanel;
use App\Models\OrderItemSize;
use App\Models\Style;
use App\Models\User;
use App\Repositories\Dtos\Order as DtoOrder;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder($order)
    {
        $orderDto = new DtoOrder();
        $orderDto->publicId = $order['public_id'];
        $orderDto->factory = Factory::find($order['factory_id']);
        $orderDto->type = $order['type'];
        $orderDto->productionRequirement = $order['production_requirement'];
        $orderDto->customer = Customer::find($order['customer_id']);
        $orderDto->salesMadeby = User::where('id','=',$order['sale_made_by_id'])->first();
        $orderDto->customerServiceBy = User::find($order['customer_service_by_id']);

        $order = Order::create([
            'public_id' => $orderDto->publicId,
            'factory_id' => $orderDto->factory->id,
            'type' => $orderDto->type,
            'production_requirement' => $orderDto->productionRequirement,
            'customer_id' => $orderDto->customer->id,
            'sale_made_by_id' => $orderDto->salesMadeby->id,
            'customer_service_by_id' => $orderDto->customerServiceBy->id
        ]);

        return $order;
    }

    public function createOrderItem($orderItem)
    {
        $orderItem = OrderItem::create([
            'order_id' => Order::find($orderItem['order_id'])->id,
            'style_id' => Style::find($orderItem['style_id'])->id,
            'production_type' => $orderItem['production_type'],
            'price' => $orderItem['price']
        ]);

        return $orderItem;
    }

    public function createOrderItemSize($orderItemSize, OrderItem $orderItem)
    {
        $orderItemSize = OrderItemSize::create([
            'order_item_id' => $orderItem->id,
            'size_id' => $orderItemSize['size_id'],
            'quantity' => $orderItemSize['quantity'],
            'unit_price' => $orderItemSize['unit_price'],
            'total_price' => $orderItemSize['unit_price'] * $orderItemSize['quantity'],
        ]);

        return $orderItemSize;
    }

    public function createOrderItemPanel($orderItemPanel, OrderItem $orderItem)
    {
        $orderItemPanel = OrderItemPanel::create([
            'order_item_id' => $orderItem->id,
            'panel_id' => $orderItemPanel['panel_id'],
            'fabric_id' => $orderItemPanel['fabric_id'],
            'fabric_variation_id' => $orderItemPanel['fabric_variation_id'],
        ]);

        return $orderItemPanel;
    }
}
