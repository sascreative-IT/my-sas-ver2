<?php
declare(strict_types = 1);

namespace App\Repositories;
use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{

    public function getAll()
    {
        return Customer::query()->withAll()->get();
    }

    public function create(array $data)
    {
        return Customer::query()->create($data);
    }

    public function show($id)
    {
        $relations = ['contacts', 'csAgent', 'salesAgent', 'logo', 'addresses.address.country'];

        return Customer::query()->with($relations)->find($id);
    }

    public function update($id, array $data)
    {
        $customer = Customer::query()->findOrFail($id);
        $customer->fill($data);
        $customer->save();

        return $customer;
    }

    public function delete($id)
    {
        $customer = Customer::query()->findOrFail($id);

        return $customer->delete();
    }

}
