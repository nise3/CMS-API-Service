<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * App\Models\Partner
 * @property int $id
 * @property string title_en
 * @property string title
 * @property string | null main_image_path
 * @property string | null thumb_image_path
 * @property string | null grid_image_path
 * @property string | null $domain
 * @property string | null image_alt_title_en
 * @property string | null image_alt_title
 * @property int row_status
 * @property int | null created_by
 * @property int | null updated_by
 * @property Carbon | null created_at
 * @property Carbon | null updated_at
 * @property Carbon | null deleted_at
 * @property  Collection cmsLanguages
 */
class Nise3Partner extends BaseModel
{
    use ScopeRowStatusTrait, SoftDeletes;

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SOFT_DELETE;

    /** NISE_3_PARTNER_LANGUAGE_FIELDS */
    public const NISE_3_PARTNER_TITLE="title";
    public const NISE_3_PARTNER_ATL_IMAGE="image_alt_title";
    public const NISE_3_PARTNER_LANGUAGE_FIELDS=[
        self::NISE_3_PARTNER_TITLE,
        self::NISE_3_PARTNER_ATL_IMAGE
    ];

}
