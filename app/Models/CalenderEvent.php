<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *Class CalenderEvent
 * @property int $id
 * @property string $title
 * @property string|null $title_en
 * @property int|null $youth_id
 * @property int|null $batch_id
 * @property int|null $program_id
 * @property int|null $training_center_id
 * @property int|null $institute_id
 * @property int|null $organization_id
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property string|null $color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class CalenderEvent extends BaseModel
{
    use SoftDeletes;

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SOFT_DELETE;

    public const CALENDER_TYPE_DAY = 'day';
    public const CALENDER_TYPE_MONTH = 'month';
    public const CALENDER_TYPE_WEEK = 'week';
    public const CALENDER_TYPE_YEAR = 'year';
    public const CALENDER_TYPE_SCHEDULE = 'schedule';

    public const CALENDER_TYPES = [
        self::CALENDER_TYPE_DAY,
        self::CALENDER_TYPE_MONTH,
        self::CALENDER_TYPE_WEEK,
        self::CALENDER_TYPE_YEAR,
        self::CALENDER_TYPE_SCHEDULE
    ];

}
