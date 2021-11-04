<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterialInventory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function variation(): BelongsTo
    {
        return $this->belongsTo( MaterialVariation::class, 'material_variation_id');
    }

    public function stockIn(): HasMany
    {
        return $this->hasMany(InventoryIn::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo( Supplier::class, 'supplier_id');
    }
}
