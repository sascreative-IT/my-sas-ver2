<?php


namespace App\Repositories\Dtos;

use App\Models\Order;
use App\Models\Style;

class OrderItem
{
    public Order $order;
    public Style $style;
    public string $productionType;
    public string $price;
}
