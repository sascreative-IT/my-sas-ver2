<?php

namespace App\Http\Controllers;

use App\Domains\Styles\Actions\CreateStyle;
use App\Domains\Styles\Dto\CustomizedStyle as StyleDto;
use App\Http\Requests\Styles\StyleStoreRequest;
use App\Models\Factory;
use App\Models\Style;
use App\Repositories\CategoryRepository;
use App\Repositories\CustomerRepositoryInterface as CustomerRepository;
use App\Repositories\ItemTypeRepository;
use App\Repositories\MaterialRepository;
use App\Repositories\SizeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExternalStylesController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        /** @var Collection $internalStyles */
        $internalStyles = Style::query()
            ->external()
            ->when($q, function ($query, $q) {
                return $query
                    ->where('code', 'like', "%{$q}%")
                    ->orWhere('name', 'like', "%{$q}%");
            })
            ->paginate()
            ->withQueryString();

        $internalStyles->loadMissing(['itemType']);

        return Inertia::render('Styles/ExternalStyles/Index', [
            'internal-styles' => $internalStyles
        ]);
    }

    public function create(
        CustomerRepository $customerRepository,
        CategoryRepository $categoryRepository,
        ItemTypeRepository $itemTypeRepository,
        SizeRepository     $sizeRepository,
        MaterialRepository $materialRepository,
        Request            $request,
    )
    {
        $factories = Factory::all();
        $customers = $customerRepository->getAll();
        $categories = $categoryRepository->getAll();
        $itemTypes = $itemTypeRepository->getAll();
        $sizes = $sizeRepository->getAll();
        $materials = $materialRepository->getAll();


        $style = new StyleDto([
            'sizes' => [],
            'panels' => [],
            'belongs_to' => 'external'
        ]);

        return Inertia::render('Styles/ExternalStyles/Create', [
            'styleData' => $style,
            'customers' => $customers,
            'categories' => $categories,
            'itemTypes' => $itemTypes,
            'sizes' => $sizes,
            'factories' => $factories,
            'materials' => $materials,
        ]);
    }

    public function store(StyleStoreRequest $request)
    {
        resolve(CreateStyle::class)->execute($request->toDto());

        return redirect('/external-styles');
    }

    public function edit(CustomerRepository $customerRepository,
                         CategoryRepository $categoryRepository,
                         ItemTypeRepository $itemTypeRepository,
                         SizeRepository     $sizeRepository,
                         MaterialRepository $materialRepository,
                         Style              $style,
                         Request            $request
    )
    {
        $factories = Factory::all();
        $customers = $customerRepository->getAll();
        $categories = $categoryRepository->getAll();
        $itemTypes = $itemTypeRepository->getAll();
        $sizes = $sizeRepository->getAll();
        $materials = $materialRepository->getAll();


        $style->load(['itemType', 'categories', 'sizes', 'factories', 'panels.consumption']);
        $styleDto = new StyleDto($style->toArray());

        return Inertia::render('Styles/ExternalStyles/Create', [
            'styleData' => $styleDto,
            'customers' => $customers,
            'categories' => $categories,
            'itemTypes' => $itemTypes,
            'sizes' => $sizes,
            'factories' => $factories,
            'materials' => $materials,
        ]);
    }
}
