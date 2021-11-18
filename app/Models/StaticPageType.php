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
    protected $table = "static_page_types";
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SOFT_DELETE;
    public const TYPE_PAGE_BLOCK = 1;
    public const TYPE_STATIC_PAGE = 2;


    public const STATIC_PAGE_TYPE_CATEGORY_COMMON = 1;
    public const STATIC_PAGE_TYPE_CATEGORY_NISE3 = 2;
    public const STATIC_PAGE_TYPE_CATEGORY_YOUTH = 3;
    public const STATIC_PAGE_TYPE_CATEGORY_TSP = 4;
    public const STATIC_PAGE_TYPE_CATEGORY_INDUSTRY = 5;
    public const STATIC_PAGE_TYPE_CATEGORY_INDUSTRY_ASSOCIATION = 6;

    public const STATIC_PAGE_TYPE_CATEGORIES= [
        self::STATIC_PAGE_TYPE_CATEGORY_COMMON => "Common",
        self::STATIC_PAGE_TYPE_CATEGORY_NISE3 => "Nise3",
        self::STATIC_PAGE_TYPE_CATEGORY_YOUTH => "Youth",
        self::STATIC_PAGE_TYPE_CATEGORY_TSP => "Training Service Provider(TSP)",
        self::STATIC_PAGE_TYPE_CATEGORY_INDUSTRY => "Organization",
        self::STATIC_PAGE_TYPE_CATEGORY_INDUSTRY_ASSOCIATION => "Industry Association"
    ];



    public const TYPES = [
        self::TYPE_PAGE_BLOCK,
        self::TYPE_STATIC_PAGE,
    ];

    /** Database Operation type */
    public const DB_OPERATION_CREATE = 'HTTP_CREATED';
    public const DB_OPERATION_UPDATE = 'HTTP_UPDATED';
}
