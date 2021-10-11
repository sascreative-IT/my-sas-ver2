<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialInvoiceItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function variation(): BelongsTo
    {
        return $this->belongsTo(MaterialVariation::class, 'material_variation_id');
    }
}
