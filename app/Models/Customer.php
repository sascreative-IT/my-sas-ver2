<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'description',
        'cs_agent_id',
        'sales_agent_id',
        'logo_id',
    ];

    public function contacts()
    {
        return $this->hasMany(CustomerContact::class);
    }

    public function csAgent()
    {
        return $this->belongsTo(User::class, 'cs_agent_id');
    }

    public function salesAgent()
    {
        return $this->belongsTo(User::class, 'sales_agent_id');
    }

    public function logo()
    {
        return $this->belongsTo(File::class);
    }

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class, 'customer_id');
    }

    public function scopeWithAll($query)
    {
        return $query->with(['csAgent', 'salesAgent', 'addresses.address.country']);
    }

}
