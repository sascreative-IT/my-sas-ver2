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
        $validated = $request->validated();
        $this->customerContactsRepository->store($validated);

        return Redirect::route('customers.edit', ['customer' => $validated['customer_id']])->with(['message' => 'successfully saved']);
    }

    public function update(CustomerContact $customerContact, UpdateCustomerContactRequest $request)
    {
        $validated = $request->validated();
        $this->customerContactsRepository->update($customerContact->id, $validated);

        return Redirect::route('customers.edit', ['customer' =>  $customerContact->customer_id])->with(['message' => 'successfully updated']);
    }

    public function delete(CustomerContact $customerContact)
    {
        $customerContact->delete();

        return Redirect::route('customers.edit', ['customer' =>  $customerContact->customer_id])->with(['message' => 'successfully deleted']);
    }
}
