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
    public string $orderId;
    public Factory $factory;
    public Customer $customer;
    public User $createdBy;
    public array $items;

    public static function fromRequest(FormRequest $request): StockOutData
    {
        return new self([
            'orderId' => $request->input('order_public_id'),
            'factory' => Factory::findOrFail($request->input('factory_id')),
            'customer' => Customer::findOrFail($request->input('customer_id')),
            'createdBy' => User::findOrFail(auth()->id()),
            'items' => array_map(
                fn($item) => StockOutItemData::fromRequest($item),
                $request->input('items')
            )
        ]);
    }
}
