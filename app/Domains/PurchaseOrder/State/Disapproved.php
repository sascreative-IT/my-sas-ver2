<?php


namespace App\Domains\PurchaseOrder\State;


class Disapproved extends MaterialPurchaseOrderState
{

    public function getColor(): string
    {
        return '#eb0f0f';
    }
}
