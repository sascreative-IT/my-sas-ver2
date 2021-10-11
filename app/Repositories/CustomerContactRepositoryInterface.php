<?php
declare(strict_types = 1);

namespace App\Repositories;


interface CustomerContactRepositoryInterface
{
    public function store(array $data);

    public function showContactsOfCustomer($customer_id);

    public function update($id, array $data);

    public function delete($id);
}
