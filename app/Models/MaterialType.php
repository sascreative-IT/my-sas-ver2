<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MaterialType extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $primaryKey = 'type';
    public $incrementing = false;
    protected $keyType = 'string';
}
