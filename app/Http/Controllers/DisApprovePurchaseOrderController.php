<?php


namespace App\Http\Controllers;


use App\Domains\PurchaseOrder\Actions\ApprovePurchaseOrderAction;
use App\Domains\PurchaseOrder\Actions\DisApprovePurchaseOrderAction;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use Illuminate\Support\Facades\Redirect;
use \Illuminate\Http\RedirectResponse;

class DisApprovePurchaseOrderController extends Controller
{
    public function __invoke(MaterialPurchaseOrder $materialPurchaseOrder): RedirectResponse
    {
        try {

            (new DisApprovePurchaseOrderAction())->execute($materialPurchaseOrder);

            return redirect()->route('purchase.orders.index')
                ->with('message', "The purchase order has been disapproved successfully.");

        } catch (\Exception $ex) {
            return redirect()->route('purchase.orders.index')
                ->with('message', "The purchase order has been failed disapproved.");
        }

    }
}
