<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SettingCategoriesController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $categories = Category::query()
            ->when($q, function ($query, $q) {
                return $query
                    ->where('name', 'like', "%{$q}%");
            })
            ->paginate()
            ->withQueryString();

        return Inertia::render(
            'Settings/Categories/Index',
            [
                'categories' => $categories
            ]
        );
    }

    public function create()
    {
        return Inertia::render('Settings/Categories/Create');
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            collect($request->validated())->map(function ($category){
                Category::create(
                    ['name' => $category['name']]
                );
            });
            return Redirect::route('settings.categories.index');
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}
