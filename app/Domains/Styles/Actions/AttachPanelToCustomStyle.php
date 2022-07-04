<?php

namespace App\Domains\Styles\Actions;

use App\Domains\Styles\Dto\CustomizedPanel;
use App\Domains\Styles\Dto\Panel;
use App\Models\Style;
use App\Models\StylePanel;

class AttachPanelToCustomStyle
{
    public function execute(Style $style, CustomizedPanel $customizedPanel): void
    {
        if ($customizedPanel->id) {
            $stylePanel = $this->createPanel($style, $customizedPanel);
        }

        $stylePanel->fabrics()->attach($customizedPanel->fabricId);
    }


    private function createPanel(Style $style, CustomizedPanel $customizedPanel): StylePanel
    {
        return StylePanel::create([
            'name' => StylePanel::query()->find($customizedPanel->id)->name,
            'style_id' => $style->id,
            'default_fabric_id' => optional($customizedPanel->fabricId)->id,
            'color_id' => $customizedPanel->colourId,
        ]);
    }

}
