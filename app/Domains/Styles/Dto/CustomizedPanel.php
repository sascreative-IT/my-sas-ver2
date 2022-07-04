<?php

namespace App\Domains\Styles\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class CustomizedPanel extends DataTransferObject
{
    public ?int $id;
    public ?int $fabricId;
    public ?int $colourId;
}
