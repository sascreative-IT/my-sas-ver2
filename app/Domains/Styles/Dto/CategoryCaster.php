<?php


namespace App\Domains\Styles\Dto;


use Exception;
use Spatie\DataTransferObject\Caster;

class CategoryCaster implements Caster
{
    public function cast(mixed $value): mixed
    {
        if (! is_array($value)) {
            throw new Exception("Can only cast arrays to Size");
        }

        return array_map(
            fn (array $data) => new Category($data),
            $value
        );
    }
}
