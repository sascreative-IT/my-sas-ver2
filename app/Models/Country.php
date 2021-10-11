<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sort'];


    public function customerAddresses()
    {
        return $this->hasManyThrough(
            CustomerAddress::class,
            Address::class,
            'country_id',
            'address_id',
            'id',
            'id'
        );
    }

}
