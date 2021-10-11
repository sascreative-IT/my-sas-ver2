<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Size;
use Illuminate\Database\Eloquent\Collection;

class SizeRepository
{
    public function getAll(): Collection
    {
        return Size::all();
    }
}
