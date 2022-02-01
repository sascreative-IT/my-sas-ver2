<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Customer;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Repositories\FileRepositoryInterface as FileRepository;
use App\Repositories\CustomerRepositoryInterface as CustomerRepository;
use App\Repositories\CsAgentRepositoryInterface as CsAgentRepository;
use App\Repositories\SalesAgentRepositoryInterface as SalesAgentRepository;
use App\Repositories\CustomerContactRepositoryInterface as CustomerContactsRepository;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomersController extends Controller
{
    protected $fileRepository;
    protected $customerRepository;
    protected $csAgentRepository;
    protected $salesAgentRepository;
    protected $customerContactsRepository;

    public function __construct(
        FileRepository $fileRepository,
        CustomerRepository $customerRepository,
        CsAgentRepository $csAgentRepository,
        SalesAgentRepository $salesAgentRepository,
        CustomerContactsRepository $customerContactsRepository
    ) {
        $this->fileRepository = $fileRepository;
        $this->customerRepository = $customerRepository;
        $this->csAgentRepository = $csAgentRepository;
        $this->salesAgentRepository = $salesAgentRepository;
        $this->customerContactsRepository = $customerContactsRepository;
    }

    public function index()
    {
        $customers = $this->customerRepository->getAll();

        return Inertia::render(
            'Customers/CustomersIndex',
            [
                'customers' => $customers
            ]
        );
    }

    public function create()
    {
        $salesAgents = $this->salesAgentRepository->getAllSalesAgents();
        $csAgents = $this->csAgentRepository->getAllCsAgents();

        return Inertia::render(
            'Customers/CustomerAdd',
            [
                'salesAgents' => $salesAgents,
                'csAgents' => $csAgents,
            ]
        );
    }

    public function store(StoreCustomerRequest $request)
    {
        try {
            $validated = $request->validated();

            $customer = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'description' => $validated['description'],
                'cs_agent_id' => $validated['cs_agent_id'],
                'sales_agent_id' => $validated['sales_agent_id'],
                'logo_id' => $validated['logo_id'],
            ];

            $savedCustomer = $this->customerRepository->create($customer);

            return Redirect::route('customers.edit', [$savedCustomer->id])
                ->with(['message' => 'successfully saved']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function edit(Customer $customer)
    {
        $savedCustomer = $this->customerRepository->show($customer->id);
        $salesAgents = $this->salesAgentRepository->getAllSalesAgents();
        $csAgents = $this->csAgentRepository->getAllCsAgents();
        $customerContacts = $this->customerContactsRepository->showContactsOfCustomer($customer->id);
        $countries = Country::all();


        return Inertia::render(
            'Customers/CustomerUpdate',
            [
                'initCustomer' => $savedCustomer,
                'salesAgents' => $salesAgents,
                'csAgents' => $csAgents,
                'contacts' => $customerContacts,
                'countries' => $countries
            ],
        );
    }

    public function update(Customer $customer, UpdateCustomerRequest $request)
    {
        try {
            $validated = $request->validated();

            $customerDetails = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'description' => $validated['description'],
                'cs_agent_id' => $validated['cs_agent_id'],
                'sales_agent_id' => $validated['sales_agent_id'],
                'logo_id' => $validated['logo_id'],
            ];

            $savedCustomer = $this->customerRepository->update($customer->id, $customerDetails);

            return Redirect::route('customers.edit', [$savedCustomer->id])
                ->with(['message' => 'successfully updated']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function delete(Customer $customer)
    {
        try {
            $this->customerRepository->delete($customer->id);

            return Redirect::route('customers.index')
                ->with(['message' => 'successfully updated']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}
