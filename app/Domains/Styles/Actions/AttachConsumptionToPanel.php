<?php
declare(strict_types=1);

namespace App\Domains\Styles\Actions;

use App\Domains\Styles\Dto\Consumption;
use App\Models\StylePanel;
use App\Models\StylePanelConsumption;

class AttachConsumptionToPanel
{
    public function execute(StylePanel $panel, Consumption $consumptionDto, string $unitType): void
    {
        if ($consumptionDto->amount != null){
            $this->createConsumption($panel, $consumptionDto, $unitType);
        }
    }

    private function createConsumption(
        StylePanel $panel,
        Consumption $consumptionDto,
        string $unitType,
    ):StylePanelConsumption
    {
        return StylePanelConsumption::create([
            'size_id' => $consumptionDto->size->id,
            'amount' => $consumptionDto->amount,
            'unit' => $unitType,
            'style_panel_id' => $panel->id,
        ]);
    }

    private function updateConsumption(
        Consumption $consumptionDto
    ): StylePanelConsumption
    {
        StylePanelConsumption::find($consumptionDto->id)
            ->update([
                $consumptionDto->toArray()
            ]);
    }
}
