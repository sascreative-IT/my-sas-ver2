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
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property Collection categories
 * @property Collection sizes
 * @property Collection factories
 *
 * @method Builder internal()
 */
class Style extends Model implements Auditable
{
    const INTERNAL = 'internal';
    const EXTERNAL = 'external';
    const GENERAL = 'General';
    const CUSTOMIZED = 'Customized';
    const NEWCUSTOMIZED = 'New-Customized';

    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

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

    public function itemType(): BelongsTo
    {
        return $this->belongsTo(ItemType::class, 'item_type_id');
    }

    public function panels(): HasMany
    {
        return $this->hasMany(StylePanel::class);
    }

    public function scopeInternal(): Builder
    {
        return $this->where('belongs_to', self::INTERNAL);
    }

    public function scopeExternal(): Builder
    {
        return $this->where('belongs_to', self::EXTERNAL);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function parentStyle(): BelongsTo
    {
        return $this->belongsTo(Style::class, 'parent_style_id');
    }

    public function deleteRelations()
    {
        $this->categories()->delete();
        $this->sizes()->delete();
        $this->factories()->delete();
        $this->itemType()->delete();
        $this->panels()->delete();
    }
}
