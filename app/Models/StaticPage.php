<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Nullable;

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
class StaticPage extends BaseModel
{
    use HasFactory, SoftDeletes;

    const CONTENT_TYPE_BLOCK = 1;
    const CONTENT_TYPE_STATIC_PAGE = 2;

    public const CONTENT_TYPES = [
        self::CONTENT_TYPE_BLOCK,
        self::CONTENT_TYPE_STATIC_PAGE
    ];

    protected $table = 'static_pages_and_block';
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SOFT_DELETE;


    const LANGUAGE_ATTR_TITLE = "title";
    const LANGUAGE_ATTR_SUB_TITLE = "sub_title";
    const LANGUAGE_ATTR_CONTENTS = "contents";

    public const STATIC_PAGE_LANGUAGE_FILLABLE = [
        self::LANGUAGE_ATTR_TITLE,
        self::LANGUAGE_ATTR_SUB_TITLE,
        self::LANGUAGE_ATTR_CONTENTS
    ];

    /**
     * @return HasMany
     */
    public function cmsLanguages(): HasMany
    {
        return $this->hasMany(CmsLanguage::class, 'key_id', "id");
    }

}
