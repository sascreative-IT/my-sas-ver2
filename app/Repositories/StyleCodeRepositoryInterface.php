<?php

declare(strict_types=1);

namespace App\Repositories;


use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Style;

interface StyleCodeRepositoryInterface
{
    public function getAll();
    public function getStyleCodesOfFactory($id);
    public function getRelationsForStyle($id);
    public function getFabricsForStyle($id);
}
