<?php


namespace App\Repositories\Dtos;


use App\Models\Customer;
use App\Models\Factory;
use App\Models\User;

class Order
{
    public string $publicId;
    public Factory $factory;
    public string $type;
    public string $productionRequirement;
    public Customer $customer;
    public User $salesMadeby;
    public User $customerServiceBy;
}
