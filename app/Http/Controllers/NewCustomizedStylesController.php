<?php

namespace App\Http\Controllers;

use App\Domains\Styles\Actions\CreateNewCustomizedStyle;
use App\Domains\Styles\Actions\CreateStyle;
use App\Domains\Styles\Actions\GetAvailableMaterialColors;
use App\Domains\Styles\Actions\GetColorsFromMaterialVariations;
use App\Domains\Styles\Actions\SaveImageAndGetPath;
use App\Domains\Styles\Actions\UpdateNewCustomizedStyle;
use App\Domains\Styles\Actions\UpdateStyle;
use App\Domains\Styles\Dto\Style as StyleDto;
use App\Http\Requests\Styles\StoreNewCustomizedStyleRequest;
use App\Http\Requests\Styles\StyleStoreRequest;
use App\Http\Requests\Styles\StyleUpdateRequest;
use App\Http\Requests\Styles\UpdateCustomizedStyleRequest;
use App\Models\Colour;
use App\Models\Factory;
use App\Models\MaterialVariation;
use App\Models\NewCustomizedStyle;
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
        $internalStyles = NewCustomizedStyle::query()
            ->internal()
            ->with('itemType')
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

        $colours = resolve(GetColorsFromMaterialVariations::class)->execute($request);

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

    public function store(StoreNewCustomizedStyleRequest $request)
    {
        try {
            $imagePath = resolve(SaveImageAndGetPath::class)->execute($request->file('image'));
            $request->merge(['style_image' => $imagePath]);
            $style = resolve(CreateNewCustomizedStyle::class)->execute($request->toDto());

            return Redirect::route('style.new-customized.index')
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
        NewCustomizedStyle $style,
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

        $colours = resolve(GetAvailableMaterialColors::class)->execute($style);

        return Inertia::render('Styles/NewCustomizedStyles/Create', [
            'styleData' => $styleDto,
            'customers' => $customers,
            'categories' => $categories,
            'itemTypes' => $itemTypes,
            'sizes' => $sizes,
            'factories' => $factories,
            'materials' => $materials,
            'colours' => $colours,
        ]);
    }

    public function update(Style $style, UpdateCustomizedStyleRequest $request)
    {
        try {
            $imagePath = resolve(SaveImageAndGetPath::class)->execute($request);
            if ($imagePath != "") {
                $request->merge(['style_image' => $imagePath]);
            }

            resolve(UpdateNewCustomizedStyle::class)->execute($style, $request->toDto());

            return Redirect::route('style.new-customized.edit', [$style->id])
                ->with(['message' => 'successfully updated']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}
