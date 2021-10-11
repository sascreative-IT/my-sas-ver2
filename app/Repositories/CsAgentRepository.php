<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\User;

class CsAgentRepository implements CsAgentRepositoryInterface
{
    public function getAllCsAgents()
    {
        return User::role('customer service agent')->get();
    }
}
