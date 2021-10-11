<?php
declare(strict_types=1);

namespace App\Domains\Styles\Dto;

use Exception;
use Spatie\DataTransferObject\Caster;

class PanelCaster implements Caster
{
    public function cast(mixed $value): mixed
    {
        if (! is_array($value)) {
            throw new Exception("Can only cast arrays to Panels");
        }

        return array_map(function (array $data) {
            return new Panel($data);
        }, $value);
    }
}
