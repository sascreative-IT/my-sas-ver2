<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Colour extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'is_active'];

    public function type(): BelongsTo
    {
        return $this->belongsTo(MaterialType::class, 'type');
    }
}
