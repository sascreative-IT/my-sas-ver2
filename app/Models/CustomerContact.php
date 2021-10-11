<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerContact extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact_no',
        'designation',
        'type',
        'customer_id'
    ];

    const PRIMARY = 'Primary';
    const OTHER = 'Other';
    public static $types = [self::PRIMARY, self::OTHER];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
