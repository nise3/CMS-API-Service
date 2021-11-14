<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *Class Slider
 * @package App\Models
 * @property int id
 * @property int show_in
 * @property int|null institute_id
 * @property int|null organization_id
 * @property int|null industry_association_id
 *
 */
class Slider extends Model
{
    use SoftDeletes, HasFactory, ScopeRowStatusTrait;

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SOFT_DELETE;


}
