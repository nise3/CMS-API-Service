<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Slider
 * @package App\Models
 * @property int id
 * @property int institute_id
 * @property int organization_id
 * @property string title
 * @property string | null title_en
 * @property string sub_title
 * @property string | null sub_title_en
 * @property string description
 * @property string link
 * @property int is_button_available
 * @property string button_text
 * @property string slider_images
 * @property string alt_title
 * @property string alt_title_en
 * @property string | null banner_template_code
 * @property int row_status
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Slider extends BaseModel
{
    use HasFactory, SoftDeletes, ScopeRowStatusTrait;

    protected $casts = [
        'slider_images' => 'array',
    ];
    protected $guarded = ['id'];


    public const IS_BUTTON_AVAILABLE_YES = 1;
    public const IS_BUTTON_AVAILABLE_NO = 0;

    /** Banner Template Type */
    public const BT_LR = "BT_LR";
    public const BT_RL = "BT_RL";
    public const BT_CB = "BT_CB";
    public const BANNER_TEMPLATE_TYPES = [
        self::BT_LR => "Banner with text left and image right",
        self::BT_RL => "Banner with text right and image left",
        self::BT_CB => "Banner with text center and image background"
    ];
    public const BANNER_CONTEXT_POSITION_LEFT = "left";
    public const BANNER_CONTEXT_POSITION_RIGHT = "right";
    public const BANNER_CONTEXT_POSITION_CENTER = "center";
    public const BANNER_CONTEXT_POSITION_BACKGROUND = "background";



    /** BANNER_LANGUAGE_FIELDS */
    public const SLIDER_LANGUAGE_ATTR_TITLE = "title";
    public const SLIDER_LANGUAGE_ATTR_SUB_TITLE = "sub_title";
    public const SLIDER_LANGUAGE_ATTR_ALT_TITLE = "alt_title";
    public const SLIDER_LANGUAGE_ATTR_BUTTON_TEXT = "button_text";
    public const SLIDER_LANGUAGE_FIELDS = [
        self::SLIDER_LANGUAGE_ATTR_TITLE,
        self::SLIDER_LANGUAGE_ATTR_SUB_TITLE,
        self::SLIDER_LANGUAGE_ATTR_ALT_TITLE,
        self::SLIDER_LANGUAGE_ATTR_BUTTON_TEXT
    ];

}
