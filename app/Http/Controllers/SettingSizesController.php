<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSizesRequest;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SettingSizesController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $sizes = Size::query()
            ->when($q, function ($query, $q) {
                return $query
                    ->where('name', 'like', "%{$q}%");
            })
            ->paginate()
            ->withQueryString();

        return Inertia::render(
            'Settings/Sizes/Index',
            [
                'sizes' => $sizes
            ]
        );
    }

    public function create()
    {
        return Inertia::render('Settings/Sizes/Create');
    }

    public function store(StoreSizesRequest $request)
    {
        try {
            collect($request->validated())->map(function ($size){
                Size::create(
                    ['name' => $size['name'], 'slug' => strtolower($size['name'])]
                );
            });
            return Redirect::route('settings.sizes.index')
                ->with(['message' => 'successfully saved']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function delete(Size $size)
    {
        try {
            $size->delete();

            return Redirect::route('settings.sizes.index')
                ->with(['message' => 'successfully deleted']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}
