<?php

namespace App\Http\Controllers;

use App\Domains\Styles\Actions\CreateCustomizedStyle;
use App\Domains\Styles\Actions\CreateStyle;
use App\Domains\Styles\Actions\GetAvailableMaterialColors;
use App\Domains\Styles\Actions\GetStyleIndex;
use App\Domains\Styles\Actions\SaveImageAndGetPath;
use App\Domains\Styles\Actions\UpdateCustomStyle;
use App\Domains\Styles\Actions\UpdateStyle;
use App\Domains\Styles\Dto\Style as StyleDto;
use App\Http\Requests\Styles\StoreCustomizedStyleRequest;
use App\Http\Requests\Styles\StyleStoreRequest;
use App\Http\Requests\Styles\StyleUpdateRequest;
use App\Http\Requests\Styles\UpdateCustomizedStyleRequest;
use App\Models\Colour;
use App\Models\CustomizedStyle;
use App\Models\Factory;
use App\Models\Style;
use App\Models\StylePanel;
use App\Models\StylePanelFabric;
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

        $internalStyles = resolve(GetStyleIndex::class)->execute(new CustomizedStyle(), 'internal', $q);

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
        $categories = $categoryRepository->getAll();
        $sizes = $sizeRepository->getAll();
        $colours = Colour::query()->get();

        $parentStyleCode = null;

        if ($request->has('parent_id')) {
            $parent_id = $request->get('parent_id');
            $parentStyleCode = Style::find($parent_id);
            $parentStyleCode->load(['itemType', 'categories', 'sizes', 'factories', 'panels.consumption']);
            $categories = $parentStyleCode->categories;
            $sizes = $parentStyleCode->sizes;
            $parentStyleCode->load(['panels.fabrics.variations.colour']);
            $colours = resolve(GetAvailableMaterialColors::class)->execute($parentStyleCode);
        }

        $style = new StyleDto([
            'sizes' => [],
            'panels' => [],
            'belongs_to' => 'internal'
        ]);

        return Inertia::render('Styles/CustomizedStyles/Create', [
            'styleData' => $style,
            'customers' => $customerRepository->getAll(),
            'categories' => $categories,
            'itemTypes' => $itemTypeRepository->getAll(),
            'sizes' => $sizes,
            'factories' => Factory::all(),
            'materials' => $materialRepository->getAll(),
            'styles' => Style::where('styles_type','LIKE', "General")->get()->toArray(),
            'parentStyleCode' => $parentStyleCode,
            'styleType' => 'Customized',
            'customer' => $request->get('customer'),
            'colours' => $colours
        ]);
    }

    public function store(StoreCustomizedStyleRequest $request)
    {
        try {
            $imagePath = resolve(SaveImageAndGetPath::class)->execute($request);
            $request->merge(['style_image' => $imagePath]);
            $style = resolve(CreateCustomizedStyle::class)->execute($request->toDto());

            return Redirect::route('style.customized.index')
                ->with(['message' => 'successfully updated']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function edit(
        MaterialRepository $materialRepository,
        CustomizedStyle $style,
        Request $request
    ) {
        $materials = $materialRepository->getAll();

        $style->load(['itemType', 'categories', 'sizes', 'factories', 'panels.consumption', 'customer', 'parentStyle','panels.color']);
        $style->load(['panels.fabrics.variations.colour']);
        $styleDto = new StyleDto($style->toArray());

        $parent_style_code = Style::find($style->parent_style_id);
        $parent_style_code->load(['itemType', 'categories', 'sizes', 'factories', 'panels.consumption', 'customer']);

        $parent_style_code->load(['panels.fabrics.variations.colour']);

        $colours = resolve(GetAvailableMaterialColors::class)->execute($parent_style_code);

        $selectedPanels = [];
        foreach ($style->panels as $panel) {
            $selectedPanels[$panel->id] = array(
                'colourId' => $panel->color_id,
                'fabricId' => $panel->default_fabric_id,
                'id' => $panel->id
            );
        }

        return Inertia::render('Styles/CustomizedStyles/Edit', [
            'styleData' => $styleDto,
            'customers' => $style->customer,
            'customer' => $style->customer->id,
            'categories' => $parent_style_code->categories,
            'itemTypes' => $parent_style_code->itemType,
            'sizes' => $parent_style_code->sizes,
            'factories' => $parent_style_code->factories,
            'materials' => $materials,
            'colours' => $colours,
            'parentStyle' => $parent_style_code,
            'thisStyle' => $style,
            'selectedPanels' => $selectedPanels
        ]);
    }

    public function update(Style $style, UpdateCustomizedStyleRequest $request)
    {
        try {
            foreach($request->customized_panels as $panel){

               $stylePanel = StylePanel::query()->find($panel['id']);

               $stylePanel->update([
                   'default_fabric_id' => $panel['fabricId'],
                   'color_id' => $panel['colourId']
               ]);
            }

            return Redirect::route('style.customized.index')
                ->with(['message' => 'successfully updated']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}
