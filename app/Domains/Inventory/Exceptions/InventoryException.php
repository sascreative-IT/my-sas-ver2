<?php

namespace App\Domains\Inventory\Exceptions;

class InventoryException extends \Exception
{
    public static function materialExists()
    {
        return new self('Material already exists');
    }
}
