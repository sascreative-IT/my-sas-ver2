<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Materials;
use Illuminate\Database\Eloquent\Collection;

class MaterialRepository
{
    public function getAll(): Collection
    {
        return Materials::all();
    }
}
