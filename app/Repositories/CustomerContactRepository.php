<?php

namespace App\Repositories;

use App\Models\CustomerContact;

class CustomerContactRepository implements CustomerContactRepositoryInterface
{
    public function store(array $data)
    {
        return CustomerContact::query()->create($data);
    }

    public function showContactsOfCustomer($customer_id)
    {
        $contacts = CustomerContact::query()->where('customer_id', $customer_id)->whereNull('deleted_at')->get();

        return $contacts;
    }

    public function update($id, array $data)
    {
        $customerContact = CustomerContact::query()->findOrFail($id);
        $customerContact->fill($data);
        $customerContact->save();

        return $customerContact;
    }

    public function delete($id)
    {
        $customerContact = CustomerContact::query()->findOrFail($id);

        return $customerContact->delete();
    }
}
