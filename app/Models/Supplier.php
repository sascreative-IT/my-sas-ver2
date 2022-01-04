<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Supplier extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'email',
        'description',
        'currency'
    ];

    const NZD = 'nzd';

    public function contacts()
    {
        return $this->hasMany(SupplierContact::class);
    }

    public function addresses()
    {
        return $this->hasMany(SupplierAddress::class,'supplier_id');
    }

    public function materialSuppliers()
    {
        return $this->hasMany(MaterialSupplier::class,'supplier_id');
    }
}
