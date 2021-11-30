<?php

namespace App\Domains\PurchaseOrder\Models;

use App\Models\MaterialVariation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class MaterialPurchaseOrderItem extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['variation'];

    public function variation(): BelongsTo
    {
        return $this->belongsTo(MaterialVariation::class, 'material_variation_id');
    }
}
