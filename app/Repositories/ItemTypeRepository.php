<?php
declare(strict_types=1);

namespace App\Repositories;


use App\Models\ItemType;
use Illuminate\Database\Eloquent\Collection;

class ItemTypeRepository
{
    public function getAll(): Collection
    {
        return ItemType::all();
    }
}
