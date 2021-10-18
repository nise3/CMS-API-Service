<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RecentActivity
 * @package App\Models
 * @property int id
 * @property string|null title_en
 * @property string|null title
 * @property int row_status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class RecentActivity extends BaseModel
{
    use SoftDeletes, HasFactory;

    public const CONTENT_TYPE_IMAGE = 1;
    public const CONTENT_TYPE_VIDEO = 2;
    public const CONTENT_TYPE_YOUTUBE = 3;

    public const CONTENT_TYPES = [
        self::CONTENT_TYPE_IMAGE,
        self::CONTENT_TYPE_VIDEO,
        self::CONTENT_TYPE_YOUTUBE,
    ];

    public const AVAILABLE_COLLAGE_POSITIONS = ['1.1', '1.2.1', '1.2.2.1', '1.2.2.2'];

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE;
    protected $table = 'recent_activities';
}
