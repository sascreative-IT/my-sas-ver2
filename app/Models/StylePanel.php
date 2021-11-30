<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class StylePanel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $with = ['fabrics','consumption','defaultFabric'];
    public $timestamps = true;

    protected $fillable = [
        'name',
        'style_id',
        'default_fabric_id',
        'created_at',
        'updated_at',
    ];

    public function consumption(): HasMany
    {
        return $this->hasMany(StylePanelConsumption::class);
    }

    public function fabrics(): BelongsToMany
    {
        return $this->belongsToMany(Materials::class, 'style_panel_fabrics', 'style_panel_id', 'material_id');
    }

    public function defaultFabric(): BelongsTo
    {
        return $this->belongsTo(Materials::class, 'default_fabric_id');
    }
}
