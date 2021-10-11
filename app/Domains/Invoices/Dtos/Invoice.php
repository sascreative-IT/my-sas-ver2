<?php
declare(strict_types=1);

namespace App\Domains\Invoices\Dtos;

use App\Models\Factory;
use App\Models\Supplier;

class Invoice
{
    public string $number;
    public string $poNumber;
    public string $invoicedDate;
    public Factory $factory;
    public Supplier $supplier;
    public array $items;
}
