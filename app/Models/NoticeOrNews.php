<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * App\Models\NoticeOrNews
 * @property int id
 * @property int type
 * @property int show_in
 * @property Carbon|null published_at
 * @property Carbon|null archived_at
 * @property string title_en
 * @property string title
 * @property int|null institute_id
 * @property int|null organization_id
 * @property int|null industry_association_id
 * @property string |null details_en
 * @property string |null details
 * @property string |null main_image_path
 * @property string |null grid_image_path
 * @property string |null thumb_image_path
 * @property string |null image_alt_title_en
 * @property string |null image_alt_title
 * @property string |null file_path
 * @property string |null file_alt_title_en
 * @property string |null file_alt_title
 * @property int row_status
 * @property int |null created_by
 * @property int |null updated_by
 * @property Carbon |null created_at
 * @property Carbon |null updated_at
 * @property  Collection cmsLanguages
 */
class NoticeOrNews extends BaseModel
{
    use SoftDeletes, HasFactory, ScopeRowStatusTrait;

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE;
    public const TYPE_NOTICE = 1;
    public const TYPE_NEWS = 2;
    public const TYPES = [
        self::TYPE_NOTICE,
        self::TYPE_NEWS,
    ];


    /** NoticeOrNews LANGUAGE FILLABLE */
    public const LANGUAGE_ATTR_TITLE = "title";
    public const LANGUAGE_ATTR_DETAILS = "details";
    public const LANGUAGE_ATTR_IMAGE_ALT_TITLE = "image_alt_title";
    public const LANGUAGE_ATTR_FILE_ALT_TITLE = "file_alt_title";

    public const NOTICE_OR_NEWS_LANGUAGE_FILLABLE = [
        self::LANGUAGE_ATTR_TITLE,
        self::LANGUAGE_ATTR_DETAILS,
        self::LANGUAGE_ATTR_IMAGE_ALT_TITLE,
        self::LANGUAGE_ATTR_FILE_ALT_TITLE
    ];

}
