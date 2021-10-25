<?php


namespace App\Domains\PurchaseOrder\State;


class Pending extends MaterialPurchaseOrderState
{

    public function getColor(): string
    {
        return '#111827';
    }
}
