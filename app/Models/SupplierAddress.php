<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'address_id'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
