<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['file_path'];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'logo_id');
    }

}
