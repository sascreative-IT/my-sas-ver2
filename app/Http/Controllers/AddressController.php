<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\AddressRepositoryInterface as AddressRepository;
use App\Repositories\CustomerRepositoryInterface as CustomerRepository;

class AddressController extends Controller
{
    protected $addressRepository;
    protected $customerRepository;

    public function __construct(AddressRepository $addressRepository, CustomerRepository $customerRepository)
    {
        $this->addressRepository = $addressRepository;
        $this->customerRepository = $customerRepository;
    }

    public function store(StoreAddressRequest $request)
    {
        try {

            $validated = $request->validated();
            $this->addressRepository->store($validated);
            $customer = $this->customerRepository->show($validated['customer_id']);

            return Redirect::route('customers.edit', ['customer' => $customer->id])
                ->with(['message' => 'successfully saved']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function update(Address $address, UpdateAddressRequest $request)
    {
        try {

            $validated = $request->validated();
            $customer = Customer::query()->find($validated['customer_id']);
            $this->addressRepository->update($address->id, $validated);

            return Redirect::route('customers.edit', ['customer' => $customer->id]);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function delete(Address $address)
    {
        try {

            $customerId = $address->customerAddresses->first()->customer_id;;
            $this->addressRepository->delete($address->id);

            return Redirect::route('customers.edit', ['customer' => $customerId]);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}
