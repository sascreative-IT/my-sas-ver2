<?php
declare(strict_types = 1);

namespace App\Repositories;

interface CustomerRepositoryInterface
{
    public function getAll();

    public function create(array $data);

    public function show($id);

    public function update($id, array $data);

    public function delete($id);

}
