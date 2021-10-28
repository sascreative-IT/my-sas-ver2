<?php

namespace App\Domains\PurchaseOrder\Models;

use App\Models\Factory;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class MaterialPurchaseOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    const EVALUATION_STATUS_APPROVED = 'Approved';
    const EVALUATION_STATUS_REJECTED = 'Rejected';

    public function items(): HasMany
    {
        return $this->hasMany(MaterialPurchaseOrderItem::class);
    }

    public function assignedFactory(): BelongsTo
    {
        return $this->belongsTo(Factory::class, 'factory_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluated_by');
    }
}
