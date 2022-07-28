<?php
namespace App\Domains\Styles\Actions;

use App\Domains\Styles\Dto\Factories;
use App\Domains\Styles\Dto\CustomizedStyle;
use App\Models\Style as StyleModel;

class UpdateCustomStyle
{
    private AttachSizeToStyle $attachSizeToStyle;
    private AttachCategoryToStyle $attachCategoryToStyle;
    private AttachFactoriesToStyle $attachFactoriesToStyle;
    private AttachPanelToCustomStyle $attachPanelToCustomStyle;

    public function __construct(
    AttachSizeToStyle $attachSizeToStyle,
    AttachCategoryToStyle $attachCategoryToStyle,
    AttachFactoriesToStyle $attachFactoriesToStyle,
    AttachPanelToCustomStyle $attachPanelToCustomStyle
    )
    {
        $this->attachSizeToStyle = $attachSizeToStyle;
        $this->attachCategoryToStyle = $attachCategoryToStyle;
        $this->attachFactoriesToStyle = $attachFactoriesToStyle;
        $this->attachPanelToCustomStyle = $attachPanelToCustomStyle;
    }

    public function execute(StyleModel $style, CustomizedStyle $styleDto): StyleModel
    {
        if($styleDto->styles_type == StyleModel::CUSTOMIZED) {

            /** @var StyleModel $style */

            $style = StyleModel::create([
                'code' => strtolower($styleDto->code),
                'name' => $styleDto->name,
                'production_time' => $styleDto->production_time,
                'item_type_id' => $styleDto->item_type->id,
                'styles_type' => $styleDto->styles_type,
                'description' => $styleDto->description,
                'belongs_to' => $styleDto->belongs_to,
                'status' => $styleDto->status,
                'customer_id' => optional($styleDto->customer)->id,
                'parent_style_id' => optional($styleDto->parent_style)->id,
                'style_image' => $styleDto->style_image
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

            if (!is_null($styleDto->customized_panels)) {
                foreach ($styleDto->customized_panels as $panel) {
                    $this->attachPanelToCustomStyle->execute($style, $panel);
                }
            }

            $style->refresh();

            return $style;
        }
    }
}
