<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class StylePanelConsumption extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $timestamps = false;
    protected $guarded = [];
    protected $with = ['size'];

    public function size(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Size::class);
    }
}
