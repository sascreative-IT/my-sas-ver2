<?php
namespace App\Domains\Styles\Actions;

use App\Domains\Styles\Dto\Factories;
use App\Domains\Styles\Dto\Style;
use App\Models\Style as StyleModel;

class UpdateCustomStyle
{
    private AttachSizeToCustomStyle $attachSizeToCustomStyle;
    private AttachCategoryToCustomStyle $attachCategoryToCustomStyle;
    private AttachFactoriesToCustomStyle $attachFactoriesToCustomStyle;
    private AttachPanelToStyle $attachPanelToStyle;

    public function __construct(
        AttachSizeToCustomStyle      $attachSizeToCustomStyle,
        AttachCategoryToCustomStyle  $attachCategoryToCustomStyle,
        AttachFactoriesToCustomStyle $attachFactoriesToStyle,
        AttachPanelToStyle     $attachPanelToStyle,
    )
    {
        $this->attachSizeToCustomStyle = $attachSizeToCustomStyle;
        $this->attachCategoryToCustomStyle = $attachCategoryToCustomStyle;
        $this->attachFactoriesToCustomStyle = $attachFactoriesToStyle;
        $this->attachPanelToStyle = $attachPanelToStyle;
    }

    public function execute(StyleModel $style,Style $styleDto): StyleModel
    {
        /** @var StyleModel $style */
        $style->update([
            'code' => $styleDto->code,
            'name' => $styleDto->name,
            'production_time' => $styleDto->production_time,
            'item_type_id' => $styleDto->item_type->id,
            'styles_type' => $styleDto->styles_type,
            'description' => $styleDto->description,
            'belongs_to' => $styleDto->belongs_to,
            'status' => $styleDto->status,
            'customer_id' => optional($styleDto->customer)->id,
            'parent_style_id' => optional($styleDto->parent_style)->id
        ]);


        if ($styleDto->style_image) {
            $style->update(
                ['style_image' => $styleDto->style_image]
            );
        }
        $this->attachSizeToCustomStyle->execute($style, $styleDto->sizes);
        $this->attachCategoryToCustomStyle->execute($style, $styleDto->categories);
        $this->attachFactoriesToCustomStyle->execute($style, $styleDto->factories);

        foreach ($styleDto->panels as $panel) {
            $this->attachPanelToStyle->execute($style, $panel);
        }

        $style->refresh();

        return $style;
    }
}
