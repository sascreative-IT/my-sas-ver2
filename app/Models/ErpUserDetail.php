<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ErpUserDetail extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'factory_id',
        'contact_number'
    ];

    public function factory()
    {
        return $this->belongsTo(Factory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
