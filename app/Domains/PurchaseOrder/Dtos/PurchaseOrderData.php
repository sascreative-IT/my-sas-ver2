<?php


namespace App\Domains\PurchaseOrder\Dtos;


use App\Models\Factory;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @property PurchaseOrderItemData[] $purchase_order_items
 */
class PurchaseOrderData extends DataTransferObject
{
    public Factory $factory;
    public Supplier $supplier;
    public ?User $approved_by;
    public ?Carbon $approved_at;
    public array $purchase_order_items;

    public static function fromRequest(FormRequest $request): PurchaseOrderData
    {
        return new self([
            'factory' => Factory::findOrFail($request->input('factory_id')),
            'supplier' => Supplier::findOrFail($request->input('supplier_id')),
            'approved_by' => User::find($request->input('approved_by')),
            'approved_at' =>  Carbon::parse($request->input('approved_at')),
            'purchase_order_items' => $request->input('purchase_order_items')
        ]);
    }
}
