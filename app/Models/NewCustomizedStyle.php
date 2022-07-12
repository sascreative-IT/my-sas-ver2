<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewCustomizedStyle extends Model
{
    use HasFactory;

    const INTERNAL = 'internal';
    const EXTERNAL = 'external';

    protected $guarded = [];

    public function scopeInternal(): Builder
    {
        return $this->where('belongs_to', self::INTERNAL);
    }

    public function scopeExternal(): Builder
    {
        return $this->where('belongs_to', self::EXTERNAL);
    }

    public function itemType(): BelongsTo
    {
        return $this->belongsTo(ItemType::class, 'item_type_id');
    }

    public function panels(): HasMany
    {
        return $this->hasMany(StylePanel::class);
    }
}

