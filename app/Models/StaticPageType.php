<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class StaticPageType
 * @package App\Models
 * @property int id
 * @property string title
 * @property string title_en
 * @property string page_code
 * @property int type
 */
class StaticPageType extends BaseModel
{
    use HasFactory;

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SOFT_DELETE;
    public const TYPE_PAGE_BLOCK = 1;
    public const TYPE_STATIC_PAGE = 2;

    public const TYPES = [
        self::TYPE_PAGE_BLOCK,
        self::TYPE_STATIC_PAGE,
    ];
}
