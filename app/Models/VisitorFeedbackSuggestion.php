<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NoticeOrNews
 * @property int id
 * @property int form_type
 * @property int show_in
 * @property int|null institute_id
 * @property int|null organization_id
 * @property int|null industry_association_id
 * @property string |null mobile
 * @property string |null email
 * @property string name_en
 * @property string name
 * @property string |null address
 * @property string |null address_en
 * @property string |null comment_en
 * @property Carbon|null read_at
 * @property Carbon|null archived_at
 * @property int|null archived_by
 * @property int row_status
 * @property Carbon |null created_at
 * @property Carbon |null updated_at
 * @property Carbon |null deleted_at
 */
class VisitorFeedbackSuggestion extends BaseModel
{
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE;
    protected $table = "visitor_feedbacks_suggestions";

    public const Form_Type_Suggestion = 1 ;
    public const Form_Type_Contactus = 2 ;

    public const Form_Type = [
        self::Form_Type_Suggestion,
        self::Form_Type_Contactus,
    ];




}
