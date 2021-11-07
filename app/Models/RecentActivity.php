<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class RecentActivity
 * @package App\Models
 * @property int $id
 * @property int $show_in
 * @property Carbon|null activity_date
 * @property Carbon|null $published_at
 * @property Carbon|null $archived_at
 * @property int|null $institute_id
 * @property int|null $organization_id
 * @property int|null $industry_association_id
 * @property string $title
 * @property string|null $title_en
 * @property int $content_type
 * @property string|null content_path
 * @property string|null embedded_url
 * @property string|null embedded_id
 * @property string|null content_properties
 * @property string|null collage_image_path
 * @property string|null collage_position
 * @property string|null thumb_image_path
 * @property string|null grid_image_path
 * @property string|null image_alt_title_en
 * @property string|null image_alt_title
 * @property string|null description_en
 * @property string|null description
 * @property int row_status
 * @property int|null published_by
 * @property int|null archived_by
 * @property int|null created_by
 * @property int|null updated_by
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 * @property  Collection cmsLanguages
 *
 */
class RecentActivity extends BaseModel
{

    use SoftDeletes, HasFactory;

    public const CONTENT_TYPE_IMAGE = 1;
    public const CONTENT_TYPE_FACEBOOK_VIDEO = 2;
    public const CONTENT_TYPE_YOUTUBE_VIDEO = 3;

    public const CONTENT_TYPES = [
        self::CONTENT_TYPE_IMAGE,
        self::CONTENT_TYPE_FACEBOOK_VIDEO,
        self::CONTENT_TYPE_YOUTUBE_VIDEO,
    ];

    /** GALLERY ALBUM LANGUAGE FILLABLE */
    public const LANGUAGE_ATTR_TITLE = "title";
    public const LANGUAGE_ATTR_IMAGE_ALT_TITLE = "image_alt_title";
    public const LANGUAGE_ATTR_DESCRIPTION = "description";

    public const RECENT_ACTIVITY_LANGUAGE_FILLABLE = [
        self::LANGUAGE_ATTR_TITLE,
        self::LANGUAGE_ATTR_IMAGE_ALT_TITLE,
        self::LANGUAGE_ATTR_DESCRIPTION,
    ];

    public const COLLAGE_POSITIONS_FIRST_ROW_FIRST_COLUMN = '1.1';
    public const COLLAGE_POSITIONS_FIRST_ROW_SECOND_COLUMN_FIRST_COLUMN = '1.2.1';
    public const COLLAGE_POSITIONS_FIRST_ROW_SECOND_COLUMN_SECOND_ROW_FIRST_COLUMN = '1.2.2.1';
    public const COLLAGE_POSITIONS_FIRST_ROW_SECOND_COLUMN_SECOND_ROW_SECOND_COLUMN = '1.2.2.2';


    public const AVAILABLE_COLLAGE_POSITIONS = [
        self::COLLAGE_POSITIONS_FIRST_ROW_FIRST_COLUMN,
        self::COLLAGE_POSITIONS_FIRST_ROW_SECOND_COLUMN_FIRST_COLUMN,
        self::COLLAGE_POSITIONS_FIRST_ROW_SECOND_COLUMN_SECOND_ROW_FIRST_COLUMN,
        self::COLLAGE_POSITIONS_FIRST_ROW_SECOND_COLUMN_SECOND_ROW_SECOND_COLUMN
    ];
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE;
    protected $table = 'recent_activities';
}
