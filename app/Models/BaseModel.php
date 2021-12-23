<?php

namespace App\Models;


use App\Traits\Scopes\ScopeAcl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package App\Models
 */
abstract class BaseModel extends Model
{
    use ScopeAcl, HasFactory;

    /**User Type*/
    public const SYSTEM_USER = 1;
    public const ORGANIZATION_USER = 2;
    public const INSTITUTE_USER = 3;
    public const YOUTH_USER_TYPE = 4;
    public const INDUSTRY_ASSOCIATION_USER = 5;

    public const IMAGE_PATH_VALIDATION_RULE = 'url';
    public const HTTP_URL = 'regex:/^(http|https):\/\/[a-zA-Z-\-\.0-9]+$/';

    public const COMMON_GUARDED_FIELDS_SIMPLE = ['id', 'created_at', 'updated_at'];
    public const COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE = ['id', 'created_at', 'updated_at', 'deleted_at'];
    public const COMMON_GUARDED_FIELDS_SOFT_DELETE = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];
    public const COMMON_GUARDED_FIELDS_NON_SOFT_DELETE = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public const ROW_STATUS_ACTIVE = 1;
    public const ROW_STATUS_INACTIVE = 0;
    public const ROW_ORDER_ASC = 'ASC';
    public const ROW_ORDER_DESC = 'DESC';


    public const  FEATURED_YES = 1;
    public const  FEATURED_NO = 0;

    public const FEATURED = [
        self::FEATURED_YES,
        self::FEATURED_NO
    ];


    public const SHOW_IN_NISE3 = 1;
    public const SHOW_IN_YOUTH = 2;
    public const SHOW_IN_TSP = 3;
    public const SHOW_IN_INDUSTRY = 4;
    public const SHOW_IN_INDUSTRY_ASSOCIATION = 5;
    public const SHOW_INS = [
        self::SHOW_IN_NISE3 => "Nise3",
        self::SHOW_IN_YOUTH => "Youth",
        self::SHOW_IN_TSP => "Training Service Provider(TSP)",
        self::SHOW_IN_INDUSTRY => "Organization",
        self::SHOW_IN_INDUSTRY_ASSOCIATION => "Industry Association"
    ];

    public const INSTITUTE_TYPE_GOVT = 1;
    public const INSTITUTE_TYPE_NON_GOVT = 2;
    public const INSTITUTE_TYPE_OTHERS_ = 3;

    public const DEFAULT_PAGE_SIZE = 10;

    /** Client Url End Point Type*/
    public const ORGANIZATION_CLIENT_URL_TYPE = "ORGANIZATION";
    public const INSTITUTE_URL_CLIENT_TYPE = "INSTITUTE";
    public const CORE_CLIENT_URL_TYPE = "CORE";
    public const YOUTH_CLIENT_URL_TYPE = "YOUTH";
    public const IDP_SERVER_CLIENT_URL_TYPE = "IDP_SERVER";
    const INSTITUTE_USER_REGISTRATION_ENDPOINT_LOCAL = '';

    public const MOBILE_REGEX = 'regex: /^(01[3-9]\d{8})$/';

    public const IS_SINGLE_RESPONSE = true;

    public const OTHER_LANGUAGE_FIELDS_KEY = 'other_language_fields';
    public const OTHER_LANGUAGE_VALIDATION_RULES = [
        self::OTHER_LANGUAGE_FIELDS_KEY => [
            'nullable',
            'array',
            'min:1',

        ],
        self::OTHER_LANGUAGE_FIELDS_KEY . '.*' => [
            "required"
        ],
    ];

    /**publish or archive status */

    public const STATUS_PUBLISH = 1;
    public const STATUS_ARCHIVE = 0;

    public const PUBLISH_OR_ARCHIVE_STATUSES = [
        self::STATUS_PUBLISH,
        self::STATUS_ARCHIVE
    ];


    /** Native Language Flag */
    public const IS_NATIVE_LANGUAGE_FLAG = 1;
    public const DEFAULT_LANGUAGE_CODE = 'bn';
    public const IS_CLIENT_SITE_RESPONSE_KEY = 'IS_CLIENT_SITE_RESPONSE_KEY';
    public const IS_CLIENT_SITE_RESPONSE_FLAG = true;
    public const IS_COLLECTION_KEY = "IS_COLLECTION_KEY";
    public const IS_COLLECTION_FLAG = true;

    /** INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID */
    public const INSTITUTE_SERVICE = "institute";
    public const ORGANIZATION_SERVICE = "organization";
    public const COURSE_AND_PROGRAM_TITLE = "course_program_title";
    public const INDUSTRY_ASSOCIATION_TITLE = "industry_association_title";
    public const COURSE_TITLE = "course_title";
    public const PROGRAM_TITLE = "program_title";
    public const INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID = "INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID";
    public const GET_INSTITUTE_TITLE_BY_ID__HTTP_CLIENT_ENDPOINT = "get-institute-title-by-ids";
    public const GET_COURSE_AND_PROGRAM_TITLE_BY_ID_HTTP_CLIENT_ENDPOINT = "get-course-program-title-by-ids";
    public const GET_ORGANIZATION_TITLE_BY_ID_HTTP_CLIENT_ENDPOINT = "get-organization-title-by-ids";
    public const GET_INDUSTRY_ASSOCIATION_TITLE_BY_ID_HTTP_CLIENT_ENDPOINT = "get-industry-association-title-by-ids";

    public const CALENDER_DEFAULT_COLOR = '#7db91c';
}
