<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerContactRequest;
use App\Http\Requests\UpdateCustomerContactRequest;
use App\Repositories\CustomerContactRepositoryInterface as CustomerContactsRepository;
use App\Models\CustomerContact;
use Illuminate\Support\Facades\Redirect;

class CustomerContactsController extends Controller
{
    protected $customerContactsRepository;

    public function __construct(CustomerContactsRepository $customerContactsRepository)
    {
        $this->customerContactsRepository = $customerContactsRepository;
    }

    public function store(StoreCustomerContactRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->customerContactsRepository->store($validated);

            return Redirect::route('customers.edit',
                ['customer' => $validated['customer_id']])
                ->with(['message' => 'successfully saved']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function update(CustomerContact $customerContact, UpdateCustomerContactRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->customerContactsRepository->update($customerContact->id, $validated);

            return Redirect::route('customers.edit',
                ['customer' => $customerContact->customer_id])
                ->with(['message' => 'successfully updated']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function delete(CustomerContact $customerContact)
    {
        try {
            $customerContact->delete();

            return Redirect::route('customers.edit',
                ['customer' => $customerContact->customer_id])
                ->with(['message' => 'successfully deleted']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}
