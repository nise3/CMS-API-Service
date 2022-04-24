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
 * @property string title_en
 * @property string title
 * @property int show_in
 * @property int|null institute_id
 * @property int|null organization_id
 * @property int|null industry_association_id
 * @property string |null description_en
 * @property string |null description
 * @property string |null image_path
 * @property string |null image_alt_title
 * @property string |null image_alt_title_en
 * @property string |null file_path
 * @property string |null author
 * @property string |null author_en
 * @property Carbon|null published_at
 * @property Carbon|null archived_at
 * @property int |null created_by
 * @property int |null updated_by
 * @property Carbon |null created_at
 * @property Carbon |null updated_at
 * @property int row_status
 * @property  Collection cmsLanguages
 */
class Publication extends BaseModel
{
    use SoftDeletes, ScopeRowStatusTrait;

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE;

    /** NoticeOrNews LANGUAGE FILLABLE */
    public const LANGUAGE_ATTR_TITLE = "title";
    public const LANGUAGE_ATTR_DESCRIPTION = "description";
    public const LANGUAGE_ATTR_AUTHOR = "author";
    public const LANGUAGE_ATTR_IMAGE_ALT_TITLE = "image_alt_title";


    public const PUBLICATION_LANGUAGE_FILLABLE = [
        self::LANGUAGE_ATTR_TITLE,
        self::LANGUAGE_ATTR_DESCRIPTION,
        self::LANGUAGE_ATTR_AUTHOR,
        self::LANGUAGE_ATTR_IMAGE_ALT_TITLE
    ];
}
