<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package App\Models
 */
abstract class BaseModel extends Model
{
    use HasFactory;


    public const IMAGE_PATH_VALIDATION_RULE='regex:/^(http|https):\/\/[a-zA-Z-\-\.0-9]+$/';
    public const HTTP_URL='regex:/^(http|https):\/\/[a-zA-Z-\-\.0-9]+$/';

    public const COMMON_GUARDED_FIELDS_SIMPLE = ['id', 'created_at', 'updated_at'];
    public const COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE = ['id', 'created_at', 'updated_at', 'deleted_at'];
    public const COMMON_GUARDED_FIELDS_SOFT_DELETE = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];
    public const COMMON_GUARDED_FIELDS_NON_SOFT_DELETE = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public const ROW_STATUS_ACTIVE = 1;
    public const ROW_STATUS_INACTIVE = 0;
    public const ROW_ORDER_ASC = 'ASC';
    public const ROW_ORDER_DESC = 'DESC';

    public const SHOW_IN_NISE3 = 1;
    public const SHOW_IN_YOUTH = 2;
    public const SHOW_IN_TSP = 3;
    public const SHOW_IN_INDUSTRY = 4;
    public const SHOW_IN_INDUSTRY_ASSOCIATION = 5;

    public const SHOW_INS = [
        self::SHOW_IN_NISE3,
        self::SHOW_IN_YOUTH,
        self::SHOW_IN_TSP,
        self::SHOW_IN_INDUSTRY,
        self::SHOW_IN_INDUSTRY_ASSOCIATION,
    ];

    public const INSTITUTE_TYPE_GOVT = 1;
    public const INSTITUTE_TYPE_NON_GOVT = 2;
    public const INSTITUTE_TYPE_OTHERS_ = 3;

    /** Institute User Type*/
    public const INSTITUTE_USER = 3;
    public const DEFAULT_PAGE_SIZE = 10;

    /** Client Url End Point Type*/
    public const ORGANIZATION_CLIENT_URL_TYPE = "ORGANIZATION";
    public const INSTITUTE_URL_CLIENT_TYPE = "INSTITUTE";
    public const CORE_CLIENT_URL_TYPE = "CORE";
    public const IDP_SERVER_CLIENT_URL_TYPE = "IDP_SERVER";
    const INSTITUTE_USER_REGISTRATION_ENDPOINT_LOCAL = '';

    public const MOBILE_REGEX = 'regex: /^(01[3-9]\d{8})$/';

    public const IS_SINGLE_RESPONSE = true;

    public const OTHER_LANGUAGE_VALIDATION_RULES = [
        'other_language_fields' => [
            'nullable',
            'array',
            'min:1',

        ],
        'other_language_fields.*' => [
            "required"
        ],
    ];


}
