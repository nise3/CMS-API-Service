<?php

namespace App\Models;

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
 * @property int row_status
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Slider extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'slider_images' => 'array',
    ];
    protected $guarded = ['id'];


    public const IS_BUTTON_AVAILABLE_YES = 1;
    public const IS_BUTTON_AVAILABLE_NO = 0;

    /** SLIDER_LANGUAGE_FIELDS */
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
