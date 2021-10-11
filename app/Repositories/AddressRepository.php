<?php


namespace App\Repositories;


use App\Models\Address;
use App\Models\Customer;
use App\Models\CustomerAddress;

class AddressRepository implements AddressRepositoryInterface
{
    public function store(array $data)
    {
        $address = [
            'line_1' => $data['line_1'],
            'line_2' => $data['line_2'],
            'line_3' => $data['line_3'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
            'country_id' => $data['country_id'],
        ];
        $savedAddress = Address::query()->create($address);
        $addressType = [
            'address_id' => $savedAddress->id,
            'type' => $data['type']
        ];

        $customerAddress = new CustomerAddress($addressType);
        $customer = Customer::query()->find($data['customer_id']);
        $customer->addresses()->save($customerAddress);

        return $savedAddress;
    }

    public function update($id, array $data)
    {
        $editedAddress = [
            'line_1' => $data['line_1'],
            'line_2' => $data['line_2'],
            'line_3' => $data['line_3'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
            'country_id' => $data['country_id'],
        ];

        $address = Address::query()->findOrFail($id);
        $updatedAddress = $address->fill($editedAddress);
        $updatedAddress->save();
        $customerAddress = CustomerAddress::query()->where('address_id','=',$address->id)->first();
        $customerAddress->update(['type' => $data['type']]);

        return $address;
    }

    public function delete($id)
    {
        $address = Address::query()->findOrFail($id);

        return $address->delete();
    }
}
