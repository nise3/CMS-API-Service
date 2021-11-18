<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class StaticPage
 * @package App\Models
 *
 * @property int id
 * @property int content_type
 * @property int show_in
 * @property string content_slug_or_id
 * @property int institute_id
 * @property int organization_id
 * @property int industry_association_id
 * @property string|null title_en
 * @property string title
 * @property string|null sub_title
 * @property string|null sub_title_en
 * @property string|null contents
 * @property string|null contents_en
 * @property int row_status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property  Collection cmsLanguages
 */
class StaticPageBlock extends BaseModel
{
    use HasFactory, SoftDeletes, ScopeRowStatusTrait;


    protected $table = 'static_page_blocks';
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SOFT_DELETE;


    public const IS_BUTTON_AVAILABLE_YES = 1;
    public const IS_BUTTON_AVAILABLE_NO = 0;

    public const IS_BUTTON_AVAILABLE = [
        self::IS_BUTTON_AVAILABLE_YES,
        self::IS_BUTTON_AVAILABLE_NO,
    ];

    public const ATTACHMENT_TYPE_IMAGE = 1;
    public const ATTACHMENT_TYPE_FACEBOOK_VIDEO = 2;
    public const ATTACHMENT_TYPE_YOUTUBE_VIDEO = 3;

    public const ATTACHMENT_TYPES = [
        self::ATTACHMENT_TYPE_IMAGE,
        self::ATTACHMENT_TYPE_FACEBOOK_VIDEO,
        self::ATTACHMENT_TYPE_YOUTUBE_VIDEO,
    ];


    public const IS_ATTACHMENT_AVAILABLE_YES = 1;
    public const IS_ATTACHMENT_AVAILABLE_NO = 0;


    public const IS_ATTACHMENT_AVAILABLE = [
        self::IS_ATTACHMENT_AVAILABLE_YES,
        self::IS_ATTACHMENT_AVAILABLE_NO
    ];

    /** Page block Template Type */
    public const PBT_LR = "PBT_LR";
    public const PBT_RL = "PBT_RL";

    public const STATIC_PAGE_BLOCK_TEMPLATE_TYPES = [
        self::PBT_LR => "Block with text left and image right",
        self::PBT_RL => "Block with text right and image left",
    ];

    public const POSITION_LEFT = "left";
    public const POSITION_RIGHT = "right";
    public const POSITION_CENTER = "center";
    public const BACKGROUND = "background";

    const LANGUAGE_ATTR_TITLE = "title";
    const LANGUAGE_ATTR_CONTENT = "content";
    const LANGUAGE_ATTR_BUTTON_TEXT = "button_text";
    const LANGUAGE_ATTR_IMAGE_ALT_TITLE = "image_alt_title";

    public const STATIC_PAGE_BLOCK_LANGUAGE_FILLABLE = [
        self::LANGUAGE_ATTR_TITLE,
        self::LANGUAGE_ATTR_CONTENT,
        self::LANGUAGE_ATTR_BUTTON_TEXT,
        self::LANGUAGE_ATTR_IMAGE_ALT_TITLE,
    ];

    /**
     * @return HasMany
     */
    public function cmsLanguages(): HasMany
    {
        return $this->hasMany(CmsLanguage::class, 'key_id', "id");
    }

}
