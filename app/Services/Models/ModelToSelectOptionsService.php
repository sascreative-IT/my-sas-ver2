<?php


namespace App\Services\Models;


use stdClass;

class ModelToSelectOptionsService
{
    public function selectOptionsObject($entities, $key, $value)
    {
        $entitiesArray = $entities->toArray();
        $optionsList = new stdClass();
        foreach ($entitiesArray as $item) {
            $optionsList->{$item[$key]} = $item[$value];
        }

        return $optionsList;
    }
}
