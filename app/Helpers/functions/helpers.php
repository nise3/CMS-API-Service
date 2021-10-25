<?php


use App\Services\ContentManagementServices\CmsLanguageService;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

if (!function_exists("clientUrl")) {
    function clientUrl($type)
    {
        if (!in_array(request()->getHost(), ['localhost', '127.0.0.1'])) {
            if ($type == "CORE") {
                return config("nise3.is_dev_mode") ? config("httpclientendpoint.core.dev") : config("httpclientendpoint.core.prod");
            } elseif ($type == "ORGANIZATION") {
                return config("nise3.is_dev_mode") ? config("httpclientendpoint.organization.dev") : config("httpclientendpoint.organization.prod");
            } elseif ($type == "INSTITUTE") {
                return config("nise3.is_dev_mode") ? config("httpclientendpoint.institute.dev") : config("httpclientendpoint.institute.prod");
            } elseif ($type == "CMS") {
                return config("nise3.is_dev_mode") ? config("httpclientendpoint.cms.dev") : config("httpclientendpoint.cms.prod");
            } elseif ($type == "YOUTH") {
                return config("nise3.is_dev_mode") ? config("httpclientendpoint.youth.dev") : config("httpclientendpoint.youth.prod");
            } elseif ($type == "IDP_SERVER") {
                return config("nise3.is_dev_mode") ? config("httpclientendpoint.idp_server.dev") : config("httpclientendpoint.idp_server.prod");
            }

        } else {
            if ($type == "CORE") {
                return config("httpclientendpoint.core.local");
            } elseif ($type == "ORGANIZATION") {
                return config("httpclientendpoint.organization.local");
            } elseif ($type == "INSTITUTE") {
                return config("httpclientendpoint.institute.local");
            } elseif ($type == "YOUTH") {
                return config("httpclientendpoint.youth.local");
            } elseif ($type == "CMS") {
                return config("httpclientendpoint.cms.local");
            } elseif ($type == "IDP_SERVER") {
                return config("nise3.is_dev_mode") ? config("httpclientendpoint.idp_server.dev") : config("httpclientendpoint.idp_server.prod");
            }
        }
        return "";
    }
}

if (!function_exists('formatApiResponse')) {
    /**
     * @param $data
     * @param $startTime
     * @param int $statusCode
     * @return array
     */
    function formatApiResponse($data, $startTime, int $statusCode = 200): array
    {
        return [
            "data" => $data ?: null,
            "_response_status" => [
                "success" => true,
                "code" => $startTime,
                "query_time" => $startTime->diffForHumans(Carbon::now())
            ]
        ];
    }
}


if (!function_exists("idpUserErrorMessage")) {

    /**
     * @param $exception
     * @return array
     */
    function idUserErrorMessage($exception): array
    {
        $statusCode = $exception->getCode();
        $errors = [
            '_response_status' => [
                'success' => false,
                'code' => ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
                "message" => "Idp User unknown error",
                "query_time" => 0
            ]
        ];

        switch ($statusCode) {
            case ResponseAlias::HTTP_UNPROCESSABLE_ENTITY:
            {
                $errors['_response_status']['code'] = ResponseAlias::HTTP_UNPROCESSABLE_ENTITY;
                $errors['_response_status']['message'] = "Username already exists in IDP";
                return $errors;
            }
            case ResponseAlias::HTTP_NOT_FOUND:
            {
                $errors['_response_status']['code'] = ResponseAlias::HTTP_NOT_FOUND;
                $errors['_response_status']['message'] = "IDP user not found";
                return $errors;
            }
            case ResponseAlias::HTTP_UNAUTHORIZED:
            {
                $errors['_response_status']['code'] = ResponseAlias::HTTP_UNAUTHORIZED;
                $errors['_response_status']['message'] = "HTTP 401 Unauthorized Error in IDP server";
                return $errors;
            }
            case 0:
            {
                $errors['_response_status']['message'] = $exception->getHandlerContext()['error'] ?? " SSL Certificate Error: An expansion of the 400 Bad Request response code, used when the client has provided an invalid client certificate";
                return $errors;
            }
            default:
            {
                return $errors;
            }

        }
    }
}
if (!function_exists("getLanguageAttributeKey")) {

    function getLanguageAttributeKey($tableName, $keyId, $language, $columnName): string
    {
        return $tableName . "_" . $keyId . "_" . $language . "_" . $columnName;
    }
}

if (!function_exists("getLanguageValue")) {

    function getLanguageValue(string $tableName, int $keyId, string $languageColumnName): array
    {
        $languageCode = request()->server('HTTP_ACCEPT_LANGUAGE');
        $response = [];
        $languageAttributeKey = getLanguageAttributeKey($tableName, $keyId, $languageCode, $languageColumnName);
        if (Cache::has($languageAttributeKey)) {
            $response[$languageColumnName . "_" . $languageCode] = Cache::get($languageAttributeKey);
        } else {
            $cmsLanguageValue = CmsLanguageService::getLanguageValueByKeyId($tableName, $keyId, $languageCode, $languageColumnName);
            if ($cmsLanguageValue) {
                $response[$languageColumnName . "_" . $languageCode] = $cmsLanguageValue;
                Cache::put($languageAttributeKey, $response[$languageColumnName . "_" . $languageCode]);
            }
        }
        return $response;
    }
}

if (!function_exists("getResponse")) {

    /**
     * @param array $responseData
     * @param Carbon $startTime
     * @param bool $responseType
     * @return array
     */
    function getResponse(array $responseData, Carbon $startTime, bool $responseType): array
    {
        $response = [];
        if (!$responseType) {
            $response['order'] = request('order') ?? "ASC";
        }
        if (!empty($responseData['data'])) {
            $response['current_page'] = $responseData['current_page'];
            $response['total_page'] = $responseData['last_page'];
            $response['page_size'] = $responseData['per_page'];
            $response['total'] = $responseData['total'];
        }
        $response['data'] = $responseData['data'] ?? $responseData;
        $response['response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];
        return $response;
    }
}


