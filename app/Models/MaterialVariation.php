<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class MaterialVariation extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Materials::class);
    }

    public function colour(): BelongsTo
    {
        return $this->belongsTo(Colour::class);
    }

    public function suppliers()
    {
        return $this->hasManyThrough(
            Supplier::class,
            MaterialSupplier::class,
            'variation_id',
            'id',
            'id',
            'supplier_id'
        )->distinct();
    }

    public function inventory(): HasOne
    {
        return $this->hasOne(MaterialInventory::class);
    }
}
