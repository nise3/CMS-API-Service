<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LocDivision
 * @package App\Models
 *
 * @property int $id
 * @property string $title
 * @property string|null $title_en
 * @property string|null $bbs_code
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection|LocUpazila[] $locUpazilas
 * @property-read Collection|LocDistrict[] $locDistricts
 */
class LocDivision extends BaseModel
{
    use SoftDeletes, HasFactory;

    protected $table = 'loc_divisions';
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SOFT_DELETE;


    public function locUpazilas(): HasMany
    {
        return $this->hasMany(LocUpazila::class, 'loc_district_id');
    }

    public function locDistricts(): HasMany
    {
        return $this->hasMany(LocDistrict::class, 'loc_district_id');
    }

}
