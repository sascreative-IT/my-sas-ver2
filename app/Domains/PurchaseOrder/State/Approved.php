<?php


namespace App\Domains\PurchaseOrder\State;


class Approved extends MaterialPurchaseOrderState
{

    public function getColor(): string
    {
        return '#111827';
    }
}
