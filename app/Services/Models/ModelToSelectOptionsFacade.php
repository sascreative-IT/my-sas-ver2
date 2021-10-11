<?php


namespace App\Services\Models;


use Illuminate\Support\Facades\Facade;

class ModelToSelectOptionsFacade extends Facade
{
    protected static function getFacadeAccessor() : string
    {
        return 'App\Services\Models\ModelToSelectOptionsService';
    }
}
