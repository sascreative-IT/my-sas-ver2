<?php
declare(strict_types = 1);

namespace App\Repositories;

interface FileRepositoryInterface
{
    public function create($data);

    public function find($id);
}
