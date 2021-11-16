<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PageBlock
 * @package App\Models
 * @property int id
 * @property int static_page_type_id
 * @property int show_in
 * @property int|null institute_id
 * @property int|null organization_id
 * @property int|null industry_association_id
 * @property string title
 * @property string|null title_en
 * @property string|null content
 * @property string|null content_en
 * @property int|null attachment_type
 * @property string|null image_path
 * @property string|null embedded_url
 * @property string|null embedded_id
 * @property string|null alt_image_title
 * @property string|null alt_image_title_en
 * @property string|null template_code
 * @property int is_button_available
 * @property int is_attachment_available
 * @property string|null button_text
 * @property int|null created_by
 * @property int|null updated_by
 * @property int|null row_status
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 */
class PageBlock extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, SoftDeletes;

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE;


    /** Page block Template Type */
    public const PBT_LR = "PBT_LR";
    public const PBT_RL = "PBT_RL";
    public const PBT_CB = "PBT_CB";

    public const PAGE_BLOCK_TEMPLATE_TYPES = [
        self::PBT_LR => "Block with text left and image right",
        self::PBT_RL => "Block with text right and image left",
        self::PBT_CB => "Block with text center and image background"
    ];

    public const POSITION_LEFT = "left";
    public const POSITION_RIGHT = "right";
    public const POSITION_CENTER = "center";
    public const BACKGROUND = "background";
}
