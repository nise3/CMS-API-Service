<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Banner
 * @package App\Models
 * @property int id
 * @property int slider_id
 * @property string title
 * @property string | null title_en
 * @property string sub_title
 * @property string | null sub_title_en
 * @property string description
 * @property string link
 * @property int is_button_available
 * @property string button_text
 * @property string image_alt_title
 * @property string alt_title_en
 * @property string | null banner_template_code
 * @property string banner_image_path
 * @property int row_status
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Banner extends BaseModel
{
    use HasFactory, SoftDeletes, ScopeRowStatusTrait;

    protected $guarded = ['id'];


    public function slider()
    {
        $this->belongsTo(Slider::class);
    }

    public const IS_BUTTON_AVAILABLE_YES = 1;
    public const IS_BUTTON_AVAILABLE_NO = 0;

    public const IS_BUTTON_AVAILABLE = [
        self::IS_BUTTON_AVAILABLE_YES,
        self::IS_BUTTON_AVAILABLE_NO
    ];

    /** Banner Template Type */
    public const BT_LR = "BT_LR";
    public const BT_RL = "BT_RL";
    public const BT_CB = "BT_CB";
    public const BT_OB = "BT_OB";
    public const BANNER_TEMPLATE_TYPES = [
        self::BT_LR => "Banner with text left anzd image right",
        self::BT_RL => "Banner with text right and image left",
        self::BT_CB => "Banner with text center and image background",
        self::BT_OB => "Banner with only background",
    ];
    public const BANNER_CONTEXT_POSITION_LEFT = "left";
    public const BANNER_CONTEXT_POSITION_RIGHT = "right";
    public const BANNER_CONTEXT_POSITION_CENTER = "center";
    public const BANNER_CONTEXT_POSITION_BACKGROUND = "background";


    /** BANNER_LANGUAGE_FIELDS */
    public const BANNER_LANGUAGE_ATTR_TITLE = "title";
    public const BANNER_LANGUAGE_ATTR_SUB_TITLE = "sub_title";
    public const BANNER_LANGUAGE_ATTR_IMAGE_ALT_TITLE = "image_alt_title";
    public const BANNER_LANGUAGE_ATTR_BUTTON_TEXT = "button_text";
    public const BANNER_LANGUAGE_FIELDS = [
        self::BANNER_LANGUAGE_ATTR_TITLE,
        self::BANNER_LANGUAGE_ATTR_SUB_TITLE,
        self::BANNER_LANGUAGE_ATTR_IMAGE_ALT_TITLE,
        self::BANNER_LANGUAGE_ATTR_BUTTON_TEXT
    ];

}
