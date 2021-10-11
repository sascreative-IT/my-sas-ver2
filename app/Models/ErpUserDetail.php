<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErpUserDetail extends Model
{
    use HasFactory;

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
