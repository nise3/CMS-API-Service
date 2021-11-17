<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticPageContent
 * @package App\Models
 * @property int id
 * @property int static_page_type_id
 * @property int show_in
 * @property int|null institute_id
 * @property int|null organization_id
 * @property int|null industry_association_id
 * @property string title
 * @property string|null title_en
 * @property string|null sub_title
 * @property string|null sub_title_en
 * @property string|null content
 * @property string|null content_en
 * @property int|null created_by
 * @property int|null updated_by
 * @property int|null row_status
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 */
class StaticPageContent extends Model
{
    use HasFactory, ScopeRowStatusTrait;

    protected $table = 'static_page_contents';

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SOFT_DELETE;

    const LANGUAGE_ATTR_TITLE = "title";
    const LANGUAGE_ATTR_SUB_TITLE = "sub_title";
    const LANGUAGE_ATTR_CONTENTS = "content";

    public const STATIC_PAGE_CONTENT_LANGUAGE_FILLABLE = [
        self::LANGUAGE_ATTR_TITLE,
        self::LANGUAGE_ATTR_SUB_TITLE,
        self::LANGUAGE_ATTR_CONTENTS
    ];
}
