<?php

namespace App\Http\Controllers;

use App\Domains\Styles\Actions\CreateStyle;
use App\Domains\Styles\Actions\UpdateCustomStyle;
use App\Domains\Styles\Actions\UpdateStyle;
use App\Domains\Styles\Dto\Style as StyleDto;
use App\Http\Requests\Styles\StyleStoreRequest;
use App\Http\Requests\Styles\StyleUpdateRequest;
use App\Models\Colour;
use App\Models\Factory;
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

class CustomizedStylesController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        /** @var Collection $internalStyles */
        $internalStyles = Style::query()
            ->internal()
            ->with('itemType')
            ->where('styles_type', "Customized")
            ->when($q, function ($query, $q) {
                return $query
                    ->where('code', 'like', "%{$q}%")
                    ->orWhere('name', 'like', "%{$q}%");
            })
            ->paginate()
            ->withQueryString();

        return Inertia::render('Styles/CustomizedStyles/Index', [
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
        $styles = Style::where('styles_type','LIKE', "General")->get()->toArray();
        $colours = Colour::query()->get();
        /*
        foreach ($styles as $style) {
            print($style['id']."-".$style['code']."<BR/>");
        }
        */
        $parentStyleCode = null;

        if ($request->has('parent_id')) {
            $parent_id = $request->get('parent_id');
            $parentStyleCode = Style::find($parent_id);
            $parentStyleCode->load(['itemType', 'categories', 'sizes', 'factories', 'panels.consumption']);
            $categories = $parentStyleCode->categories;
            $sizes = $parentStyleCode->sizes;


            $parentStyleCode->load(['panels.fabrics.variations.colour']);

            // Following code might not be needed
            $material_ids = [];
            foreach($parentStyleCode->panels as $panel){
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

            $colours = $avail_materials_colours;

        }

        $style = new StyleDto([
            'sizes' => [],
            'panels' => [],
            'belongs_to' => 'internal'
        ]);

        return Inertia::render('Styles/CustomizedStyles/Create', [
            'styleData' => $style,
            'customers' => $customers,
            'categories' => $categories,
            'itemTypes' => $itemTypes,
            'sizes' => $sizes,
            'factories' => $factories,
            'materials' => $materials,
            'styles' => $styles,
            'parentStyleCode' => $parentStyleCode,
            'styleType' => 'Customized',
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
            return Redirect::route('style.customized.index')
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
    ) {
        $factories = Factory::all();
        $customers = $customerRepository->getAll();
        $categories = $categoryRepository->getAll();
        $itemTypes = $itemTypeRepository->getAll();
        $sizes = $sizeRepository->getAll();
        $materials = $materialRepository->getAll();
        $colours = Colour::query()->get();


        $style->load(['itemType', 'categories', 'sizes', 'factories', 'panels.consumption', 'customer', 'parentStyle','panels.color']);
        $styleDto = new StyleDto($style->toArray());

        $parent_style_code = Style::find($style->parent_style_id);
        $parent_style_code->load(['itemType', 'categories', 'sizes', 'factories', 'panels.consumption', 'customer']);

        $material_ids = [];
        foreach($parent_style_code->panels as $panel){
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

        $colours = $avail_materials_colours;

        return Inertia::render('Styles/CustomizedStyles/Create', [
            'styleData' => $styleDto,
            'customers' => $parent_style_code->customer,
            'categories' => $parent_style_code->categories,
            'itemTypes' => $parent_style_code->itemType,
            'sizes' => $parent_style_code->sizes,
            'factories' => $parent_style_code->factories,
            'materials' => $materials,
            'colours' => $colours,
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

            resolve(UpdateCustomStyle::class)->execute($style, $request->toDto());

            return Redirect::route('style.customized.edit', [$style->id])
                ->with(['message' => 'successfully updated']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}
