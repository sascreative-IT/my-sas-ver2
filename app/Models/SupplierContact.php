<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact_number',
        'designation',
        'type',
        'supplier_id'
    ];

    const PRIMARY = 'Primary';
    const OTHER = 'Other';
    public static $types = [self::PRIMARY, self::OTHER];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
