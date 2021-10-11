<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Collection categories
 * @property Collection sizes
 * @property Collection factories
 *
 * @method Builder internal()
 */
class Style extends Model
{
    const INTERNAL = 'internal';
    const EXTERNAL = 'external';


    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class);
    }

    public function factories(): BelongsToMany
    {
        return $this->BelongsToMany(Factory::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ItemType::class, 'type_id');
    }

    public function panels(): HasMany
    {
        return $this->hasMany(StylePanel::class);
    }

    public function scopeInternal(): Builder
    {
        return $this->where('belongs_to', self::INTERNAL);
    }
}
