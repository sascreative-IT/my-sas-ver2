<?php
declare(strict_types=1);

namespace App\Domains\Styles\Actions;

use App\Domains\Styles\Dto\Style;
use App\Models\Style as StyleModel;

class UpdateStyle
{
    private AttachSizeToStyle $attachSizeToStyle;
    private AttachCategoryToStyle $attachCategoryToStyle;
    private AttachFactoriesToStyle $attachFactoriesToStyle;
    private AttachPanelToStyle $attachPanelToStyle;

    public function __construct(
        AttachSizeToStyle      $attachSizeToStyle,
        AttachCategoryToStyle  $attachCategoryToStyle,
        AttachFactoriesToStyle $attachFactoriesToStyle,
        AttachPanelToStyle     $attachPanelToStyle,
    )
    {
        $this->attachSizeToStyle = $attachSizeToStyle;
        $this->attachCategoryToStyle = $attachCategoryToStyle;
        $this->attachFactoriesToStyle = $attachFactoriesToStyle;
        $this->attachPanelToStyle = $attachPanelToStyle;
    }

    public function execute(StyleModel $style,Style $styleDto): StyleModel
    {
        /** @var StyleModel $style */
        $style->update([
            'code' => $styleDto->code,
            'name' => $styleDto->name,
            'production_time' => $styleDto->production_time,
            'type_id' => $styleDto->type->id,
            'description' => $styleDto->description,
            'belongs_to' => $styleDto->belongs_to,
            'status' => $styleDto->status,
            'customer_id' => optional($styleDto->customer)->id
        ]);

        foreach ($styleDto->sizes as $size) {
            $this->attachSizeToStyle->execute($style, $size);
        }

        foreach ($styleDto->categories as $category) {
            $this->attachCategoryToStyle->execute($style, $category);
        }

        foreach ($styleDto->factories as $factory) {
            $this->attachFactoriesToStyle->execute($style, $factory);
        }

        foreach ($styleDto->panels as $panel) {
            $this->attachPanelToStyle->execute($style, $panel);
        }

        return $style;
    }
}
