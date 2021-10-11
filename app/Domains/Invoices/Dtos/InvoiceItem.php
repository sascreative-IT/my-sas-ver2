<?php
declare(strict_types=1);

namespace App\Domains\Invoices\Dtos;

use App\Models\Colour;
use App\Models\Materials;

class InvoiceItem
{
    public Materials $material;
    public Colour $colour;
    public float $quantity;
    public float $price;
}
