<?php

namespace App\Models;


use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

/**
 * Class GalleryImageVideo
 * @property int id
 * @property int $gallery_album_id
 * @property int $featured
 * @property Carbon|null $published_at
 * @property Carbon|null $archived_at
 * @property int $content_type
 * @property int $video_type
 * @property string|null title
 * @property string|null title_en
 * @property string|null description
 * @property string|null description_en
 * @property string|null image_path
 * @property string|null video_url
 * @property string|null video_id
 * @property string|null $content_properties_json
 * @property string|null content_grid_image_path
 * @property string|null content_thumb_image_path
 * @property string|null image_alt_title
 * @property string|null image_alt_title_en
 * @property int $row_status
 * @property int|null published_by
 * @property int|null archived_by
 * @property int|null created_by
 * @property int|null updated_by
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 * @property Carbon|null deleted_at
 * @property  Collection cmsLanguages
 */
class GalleryImageVideo extends BaseModel
{
    use ScopeRowStatusTrait, SoftDeletes, HasFactory;

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SOFT_DELETE;
    protected $table = 'gallery_images_videos';

    const CONTENT_TYPE_IMAGE = 1;
    const CONTENT_TYPE_VIDEO = 2;

    /** GALLERY_IMAGE_VIDEO_CONTENT_TYPES */
    const CONTENT_TYPES = [
        self::CONTENT_TYPE_IMAGE,
        self::CONTENT_TYPE_VIDEO
    ];

    protected $casts = [
        'content_properties_json' => 'array'
    ];

    const VIDEO_TYPE_YOUTUBE = 1;
    const VIDEO_TYPE_FACEBOOK = 2;


    /** GALLERY_IMAGE_VIDEO_VIDEO_TYPES */
    const VIDEO_TYPES = [
        self::VIDEO_TYPE_YOUTUBE,
        self::VIDEO_TYPE_FACEBOOK
    ];

    /** GALLERY_IMAGE_VIDEO_LANGUAGE_FILLABLE */
    const LANGUAGE_ATTR_TITLE = "title";
    const LANGUAGE_ATTR_DESCRIPTION = "description";
    const LANGUAGE_ATTR_IMAGE_ALT_TITLE = "image_alt_title";

    public const GALLERY_IMAGE_VIDEO_LANGUAGE_FILLABLE = [
        self::LANGUAGE_ATTR_TITLE,
        self::LANGUAGE_ATTR_DESCRIPTION,
        self::LANGUAGE_ATTR_IMAGE_ALT_TITLE
    ];

    /**
     * @return HasMany
     */
    public function cmsLanguages(): HasMany
    {
        return $this->hasMany(CmsLanguage::class, 'key_id', "id");
    }

    public function galleryAlbum(): BelongsTo
    {
        return $this->belongsTo(GalleryAlbum::class);
    }

}
