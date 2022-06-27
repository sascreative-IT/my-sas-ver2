<?php

namespace App\Http\Controllers;

use App\Domains\Styles\Actions\CreateStyle;
use App\Domains\Styles\Actions\UpdateStyle;
use App\Domains\Styles\Dto\Style as StyleDto;
use App\Http\Requests\Styles\StyleStoreRequest;
use App\Http\Requests\Styles\StyleUpdateRequest;
use App\Models\Colour;
use App\Models\Factory;
use App\Models\MaterialVariation;
use App\Models\Style;
use App\Repositories\CategoryRepository;
use App\Repositories\CustomerRepositoryInterface as CustomerRepository;
use App\Repositories\ItemTypeRepository;
use App\Repositories\MaterialRepository;
use App\Repositories\SizeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class NewCustomizedStylesController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        /** @var Collection $internalStyles */
        $internalStyles = Style::query()
            ->internal()
            ->with('itemType')
            ->where('styles_type', "New-Customized")
            ->when($q, function ($query, $q) {
                return $query
                    ->where('code', 'like', "%{$q}%")
                    ->orWhere('name', 'like', "%{$q}%");
            })
            ->paginate()
            ->withQueryString();

        return Inertia::render('Styles/NewCustomizedStyles/Index', [
            'internal-styles' => $internalStyles
        ]);
    }

    public function create(
        CustomerRepository $customerRepository,
        CategoryRepository $categoryRepository,
        ItemTypeRepository $itemTypeRepository,
        SizeRepository $sizeRepository,
        MaterialRepository $materialRepository,
        Request $request,
    ) {
        $factories = Factory::all();
        $customers = $customerRepository->getAll();
        $categories = $categoryRepository->getAll();
        $itemTypes = $itemTypeRepository->getAll();
        $sizes = $sizeRepository->getAll();
        $materials = $materialRepository->getAll();
        $styles = Style::all('id', 'code', 'name')->toArray();
        $colours = '';

        $parent_style_code = null;

//        if ($request->has('parent_id')) {
//            $parent_id = $request->get('parent_id');
//            $parent_style_code = Style::find($parent_id);
//            $parent_style_code->load(['itemType', 'categories', 'sizes', 'factories', 'panels.consumption']);
//        }

        if ($request->filled('material_id')) {
            $material_id = $request->get('material_id');
            $colourIds = collect(
                MaterialVariation::query()
                    ->where('material_id', $material_id)
                    ->get()
            )->pluck('colour_id')->toArray();
            $colours = Colour::query()->whereIn('id', $colourIds)->get();
        }


        $style = new StyleDto([
            'sizes' => [],
            'panels' => [],
            'belongs_to' => 'internal'
        ]);

        return Inertia::render('Styles/NewCustomizedStyles/Create', [
            'styleData' => $style,
            'customers' => $customers,
            'categories' => $categories,
            'itemTypes' => $itemTypes,
            'sizes' => $sizes,
            'factories' => $factories,
            'materials' => $materials,
            'styles' => $styles,
            'styleType' => 'New-Customized',
            'customer' => $request->get('customer'),
            'colours' => $colours
        ]);
    }

    public function store(StyleStoreRequest $request)
    {
        try {
            $image_path = '';

            if ($request->hasFile('image')) {
                $image_path = $request->file('image')->store('style_images', 'public');
            }
            $request->merge(['style_image' => $image_path]);
            $style = resolve(CreateStyle::class)->execute($request->toDto());

            return Redirect::route('style.new-customized.edit', [$style->id])
                ->with(['message' => 'successfully updated']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function edit(
        CustomerRepository $customerRepository,
        CategoryRepository $categoryRepository,
        ItemTypeRepository $itemTypeRepository,
        SizeRepository $sizeRepository,
        MaterialRepository $materialRepository,
        Style $style,
        Request $request
    )
    {
        $factories = Factory::all();
        $customers = $customerRepository->getAll();
        $categories = $categoryRepository->getAll();
        $itemTypes = $itemTypeRepository->getAll();
        $sizes = $sizeRepository->getAll();
        $materials = $materialRepository->getAll();

        $style->load(['itemType', 'categories', 'sizes', 'factories', 'panels.consumption', 'customer', 'parentStyle', 'panels.color']);
        $styleDto = new StyleDto($style->toArray());

        $material_ids = [];

        foreach($style->panels as $panel){
            $material_ids[] = $panel->fabrics[0]->id;
        }

        $avail_materials_colours = DB::table('material_variations')
            ->join('material_inventories', function ($join) use ($material_ids) {
                $join->on('material_variations.id', '=', 'material_inventories.material_variation_id')
                    ->whereIn('material_variations.material_id', $material_ids);
            })
            ->join('colours', 'material_variations.colour_id', '=', 'colours.id')
            ->groupBy('colours.id')
            ->select('colours.*')
            ->get();

        return Inertia::render('Styles/NewCustomizedStyles/Create', [
            'styleData' => $styleDto,
            'customers' => $customers,
            'categories' => $categories,
            'itemTypes' => $itemTypes,
            'sizes' => $sizes,
            'factories' => $factories,
            'materials' => $materials,
            'colours' => $avail_materials_colours,
        ]);
    }

    public function update(Style $style, StyleUpdateRequest $request)
    {
        try {
            $image_path = '';
            if ($request->hasFile('image')) {
                $image_path = $request->file('image')->store('style_images', 'public');
                if ($image_path != "") {
                    $request->merge(['style_image' => $image_path]);
                }
            }

            resolve(UpdateStyle::class)->execute($style, $request->toDto());

            return Redirect::route('style.new-customized.edit', [$style->id])
                ->with(['message' => 'successfully updated']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}
