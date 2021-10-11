<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\User;

class SalesAgentRepository implements SalesAgentRepositoryInterface
{
    public function getAllSalesAgents()
    {
        return User::role('sales agent')->get();
    }
}
