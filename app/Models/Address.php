<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Address extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'line_1',
        'line_2',
        'line_3',
        'city',
        'postal_code',
        'country_id'
    ];

    public $timestamps = false;

    public function customerAddresses()
    {
        return $this->hasMany(CustomerAddress::class, 'address_id');
    }

    public function supplierAddresses()
    {
        return $this->hasMany(SupplierAddress::class, 'address_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
