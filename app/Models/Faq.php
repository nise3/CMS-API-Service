<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;


/**
 *Class Faq
 * @property int $id
 * @property int $show_in
 * @property int|null $institute_id
 * @property int|null $industry_association_id
 * @property int|null $organization_id
 * @property string $question
 * @property string|null $question_en
 * @property string $answer
 * @property string|null $answer_en
 * @property int $row_status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property  Collection cmsLanguages
 */
class Faq extends BaseModel
{
    use SoftDeletes, HasFactory;

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SOFT_DELETE;

    /** FAQ LANGUAGE FILLABLE */
    public const LANGUAGE_ATTR_QUESTION = "question";
    public const LANGUAGE_ATTR_ANSWER = "answer";

    public const FAQ_LANGUAGE_FILLABLE = [
        self::LANGUAGE_ATTR_QUESTION,
        self::LANGUAGE_ATTR_ANSWER
    ];

    public function cmsLanguage():HasMany
    {
        return $this->hasMany(CmsLanguage::class, "key_id");
    }


}
