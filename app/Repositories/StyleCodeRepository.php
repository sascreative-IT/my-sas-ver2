<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Customer;
use App\Models\Factory;
use App\Models\Materials;
use App\Models\OrderItem;
use App\Models\OrderItemPanel;
use App\Models\OrderItemSize;
use App\Models\Style;
use App\Models\User;
use App\Repositories\Dtos\Order as DtoOrder;
use App\Models\Order;
use App\Repositories\Dtos\OrderItem as OrderItemDto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StyleCodeRepository implements StyleCodeRepositoryInterface
{
    public function getAll(): Collection
    {
        return Style::all();
    }

    public function getStyleCodesOfFactory($id): Collection
    {
        if ($id === null) {
            throw new ModelNotFoundException("Style not found");
        }

        $styles = Style::query()->whereHas('factories', function ($query) use ($id) {
            $query->where('factory_id', $id);
        })->select(['id', 'name']);

        return $styles->get();
    }

    public function getRelationsForStyle($id)
    {
        if ($id === null) {
            throw new ModelNotFoundException("Style not found");
        }

        $details = Style::with([
            'sizes',
            'panels',
            'panels.fabrics',
            'panels.fabrics.variations',
            'panels.fabrics.variations.colour',
            'panels.fabrics.variations.inventory',
            'panels.defaultFabric'
        ])->find($id);

        return $details;
    }

    public function getFabricsForStyle($id)
    {
        if ($id === null) {
            throw new ModelNotFoundException("Style not found");
        }

        $styleFabrics = Materials::query()->whereHas('stylePanels', function ($query) use ($id) {
            $query->where('style_id', $id);
        })->get();

        $styleFabrics->loadMissing(['variations', 'variations.colour', 'variations.inventory']);

        return $styleFabrics;
    }

}
