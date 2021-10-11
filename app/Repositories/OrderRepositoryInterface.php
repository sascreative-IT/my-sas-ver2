<?php


namespace App\Repositories;


use App\Models\OrderItem;

interface OrderRepositoryInterface
{
    public function createOrder($order);
    public function createOrderItem($orderItem);
    public function createOrderItemSize($orderItemSize, OrderItem $orderItem);
    public function createOrderItemPanel($orderItemPanel, OrderItem $orderItem);
}
