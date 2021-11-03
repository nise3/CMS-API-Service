<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class GalleryCategory
 * @package App\Models
 *
 * @property int $id
 * @property int|null $parent_gallery_album_id
 * @property int $featured
 * @property int $show_in
 * @property int $album_type
 * @property Carbon|null $published_at
 * @property Carbon|null $archived_at
 * @property int|null $institute_id
 * @property int|null $organization_id
 * @property int|null $industry_association_id
 * @property int|null $batch_id
 * @property int|null $program_id
 * @property string $title
 * @property string|null $title_en
 * @property string|null $main_image_path
 * @property string|null $thumb_image_path
 * @property string|null $grid_image_path
 * @property string|null $image_alt_title
 * @property string|null $image_alt_title_en
 * @property int $row_status
 * @property int|null created_by
 * @property int|null updated_by
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 */
class GalleryAlbum extends BaseModel
{
    use ScopeRowStatusTrait, SoftDeletes, HasFactory;

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SOFT_DELETE;
    protected $table = 'gallery_albums';

    public const GALLERY_ALBUM_TYPE_IMAGE = 1;
    public const GALLERY_ALBUM_TYPE_VIDEO = 2;
    public const GALLERY_ALBUM_TYPE_MIXED = 3;

    public const GALLERY_ALBUM_TYPES = [
        self::GALLERY_ALBUM_TYPE_IMAGE,
        self::GALLERY_ALBUM_TYPE_VIDEO,
        self::GALLERY_ALBUM_TYPE_MIXED,
    ];

    /** GALLERY ALBUM LANGUAGE FILLABLE */
    public const LANGUAGE_ATTR_TITLE = "title";
    public const LANGUAGE_ATTR_IMAGE_ALT_TITLE = "image_alt_title";

    public const GALLERY_ALBUM_LANGUAGE_FILLABLE = [
        self::LANGUAGE_ATTR_TITLE,
        self::LANGUAGE_ATTR_IMAGE_ALT_TITLE
    ];

    /**
     * @return HasMany
     */
    public function cmsLanguages(): HasMany
    {
        return $this->hasMany(CmsLanguage::class, 'key_id', "id");
    }


}
