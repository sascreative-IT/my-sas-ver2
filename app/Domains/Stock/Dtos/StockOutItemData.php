<?php


namespace App\Domains\Stock\Dtos;


use App\Models\Colour;
use App\Models\Materials;
use App\Models\Style;
use App\Models\StylePanel;
use App\Models\Supplier;
use Spatie\DataTransferObject\DataTransferObject;

class StockOutItemData extends DataTransferObject
{
    public Style $style;
    public StylePanel $stylePanel;
    public Supplier $supplier;
    public Materials $material;
    public Colour $colour;
    public float $pieces;
    public float $usage;

    public static function fromRequest(array $data): StockOutItemData
    {
        return new self([
            'supplier' => Supplier::findOrFail($data['supplier']['id']),
            'style' => isset($data['style_id']) ? Style::findOrFail($data['style_id']) : null,
            'stylePanel' => isset($data['style_panel_id']) ? StylePanel::find($data['style_panel_id']) : null,
            'material' => isset($data['material_id']) ? Materials::find($data['material_id']) : null,
            'colour' => isset($data['colour_id']) ? Colour::find($data['colour_id']) : null,
            'pieces' => $data['pieces'],
            'usage' => $data['usage'],
        ]);
    }
}
