<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemTypeRequest;
use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ItemTypesController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $itemTypes = ItemType::query()
            ->when($q, function ($query, $q) {
                return $query
                    ->where('name', 'like', "%{$q}%");
            })
            ->paginate()
            ->withQueryString();

        return Inertia::render(
            'Settings/ItemTypes/Index',
            [
                'item_types' => $itemTypes
            ]
        );
    }

    public function create()
    {
        return Inertia::render('Settings/ItemTypes/Create');
    }

    public function store(StoreItemTypeRequest $request)
    {
        try {
            $validated = $request->validated();
            ItemType::create($validated);

            return Redirect::route('settings.item-types.index')
                ->with(['message' => 'successfully saved']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}
