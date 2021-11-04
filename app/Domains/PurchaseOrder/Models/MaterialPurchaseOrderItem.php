<?php

namespace App\Domains\PurchaseOrder\Models;

use App\Models\MaterialVariation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialPurchaseOrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['variation'];

    public function variation(): BelongsTo
    {
        return $this->belongsTo(MaterialVariation::class, 'material_variation_id');
    }
}
