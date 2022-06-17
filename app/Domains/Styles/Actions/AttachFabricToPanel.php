<?php
declare(strict_types=1);

namespace App\Domains\Styles\Actions;

use App\Domains\Styles\Dto\Fabric;
use App\Models\StylePanel;

class AttachFabricToPanel
{
    public function execute(StylePanel $panel, Fabric $fabricDto, $customStyle = false)
    {
        if ($customStyle) {
            $panel->fabrics()->sync([$fabricDto->id]);
        } else {
            $panel->fabrics()->syncWithoutDetaching([$fabricDto->id]);
        }
    }
}
