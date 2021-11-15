<?php


namespace App\Domains\PurchaseOrder\Dtos;


use App\Http\Requests\PurchaseOrder\StorePurchaseOrderItemRequest;
use App\Models\Factory;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;


class PurchaseOrderData extends DataTransferObject
{
    public Factory $factory;
    public Supplier $supplier;
    public array $purchase_order_items;

    public static function fromRequest(FormRequest $request): PurchaseOrderData
    {
        return new self([
            'factory' => Factory::findOrFail($request->input('factory_id')),
            'supplier' => Supplier::findOrFail($request->input('supplier_id')),
            'purchase_order_items' => array_map(
                fn($item) => PurchaseOrderItemData::fromRequest($item),
                $request->input('items')
            )
        ]);
    }
}
