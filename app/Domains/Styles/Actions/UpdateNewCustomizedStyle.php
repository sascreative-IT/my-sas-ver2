<?php
declare(strict_types=1);

namespace App\Domains\Styles\Actions;

use App\Domains\Styles\Dto\Style;
use App\Models\NewCustomizedStyle as StyleModel;

class UpdateNewCustomizedStyle
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

    public function execute(StyleModel $style, Style $styleDto): StyleModel
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
        ]);

        if ($styleDto->style_image) {
            $style->update(
                ['style_image' => $styleDto->style_image]
            );
        }

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

        $style->refresh();

        return $style;
    }
}
