<?php


namespace App\Domains\PurchaseOrder\State;


use Spatie\ModelStates\Exceptions\InvalidConfig;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class MaterialPurchaseOrderState extends State
{
    abstract public function getColor(): string;

    public static function config(): StateConfig
    {
        try {
            return parent::config()
                ->default(Pending::class)
                ->allowTransition(Pending::class, Approved::class)
                ->allowTransition(Pending::class, Disapproved::class);
        } catch (InvalidConfig $e) {
            throw $e;
        }
    }
}
