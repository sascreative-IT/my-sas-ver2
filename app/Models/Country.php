<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Country extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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
