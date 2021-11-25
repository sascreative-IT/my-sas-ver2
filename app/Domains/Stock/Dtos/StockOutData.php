<?php


namespace App\Domains\Stock\Dtos;


use App\Models\Customer;
use App\Models\Factory;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;

class StockOutData extends DataTransferObject
{
    public Order $order;
    public Factory $factory;
    public Customer $customer;
    public User $createdBy;
    public array $items;

    public static function fromRequest(FormRequest $request): StockOutData
    {
        return new self([
            'order' =>  Order::where('public_id', $request->input('order_public_id'))->firstOrFail(),
            'factory' => Factory::findOrFail($request->input('factory_id')),
            'customer' => Customer::findOrFail($request->input('customer_id')),
            'createdBy' => User::findOrFail($request->input('created_by_id')),
            'items' => array_map(
                fn($item) => StockOutItemData::fromRequest($item),
                $request->input('items')
            )
        ]);
    }
}
