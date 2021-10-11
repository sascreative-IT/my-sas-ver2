<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

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
