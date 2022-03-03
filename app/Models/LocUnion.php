<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocUnion extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'loc_unions';
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SOFT_DELETE;

    public function locDistrict(): BelongsTo
    {
        return $this->belongsTo(LocDistrict::class, 'loc_district_id');
    }

    public function locDivision(): BelongsTo
    {
        return $this->belongsTo(LocDivision::class, 'loc_division_id');
    }

    public function locUpazila(): BelongsTo
    {
        return $this->belongsTo(LocDivision::class, 'loc_upazila_id');
    }
}
