<?php

namespace App\Models\MySas;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $connection = 'mysas';

    public function addresses()
    {
        return $this->hasMany(ClientAddressDetail::class, 'client_id');
    }

    public function contacts()
    {
        return $this->hasMany(ClientContactDetail::class, 'client_id');
    }
}
