<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class MaterialInvoiceItem extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    public function variation(): BelongsTo
    {
        return $this->belongsTo(MaterialVariation::class, 'material_variation_id');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(MaterialInvoice::class, 'material_invoice_id');
    }
}
