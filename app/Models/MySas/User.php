<?php

namespace App\Models\MySas;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mysas';



    public function factories()
    {
        return $this->belongsToMany(Factory::class,'user_factories','user_id','factory_id');
    }
}
