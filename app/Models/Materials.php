<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Materials extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'unit'
    ];

    public function stylePanels(): BelongsToMany
    {
        return $this->belongsToMany(StylePanel::class, 'style_panel_fabrics', 'material_id');
    }

    public function variations(): HasMany
    {
        return $this->hasMany(MaterialVariation::class, 'material_id');
    }
}
