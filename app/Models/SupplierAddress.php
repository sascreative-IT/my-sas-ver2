<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SupplierAddress extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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
