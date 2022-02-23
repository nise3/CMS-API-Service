<?php

namespace App\Models;

use Carbon\Carbon;

/**
 *Class CmsLanguage
 * @property int $id
 * @property string $table_name
 * @property int $key_id
 * @property string $lang_code
 * @property string column_name
 * @property string $column_value
 * @property Carbon | null $created_at
 * @property Carbon | null $updated_at
 */
class CmsLanguage extends BaseModel
{
    public $timestamps = false;

    protected $guarded = ["id"];

}
