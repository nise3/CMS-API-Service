<?php


use App\Services\ContentManagementServices\CmsLanguageService;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

if (!function_exists("clientUrl")) {
    function clientUrl($type)
    {
        return config("httpclientendpoint." . $type);
    }
}

if (!function_exists('formatApiResponse')) {
    /**
     * @param $data
     * @param $startTime
     * @param int $statusCode
     * @return array
     */
    #[ArrayShape(["data" => "mixed|null", "_response_status" => "array"])]
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
    #[ArrayShape(['_response_status' => "array"])]
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
            case ResponseAlias::HTTP_BAD_REQUEST:
            {
                $errors['_response_status']['code'] = ResponseAlias::HTTP_BAD_REQUEST;
                $errors['_response_status']['message'] = "HTTP 400 BAD Request Error in IDP server";
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
            $response[$languageColumnName . "_" . strtolower($languageCode)] = Cache::get($languageAttributeKey);
        } else {
            $cmsLanguageValue = CmsLanguageService::getLanguageValueByKeyId($tableName, $keyId, $languageCode, $languageColumnName);
            if ($cmsLanguageValue) {
                $response[$languageColumnName . "_" . strtolower($languageCode)] = $cmsLanguageValue;
                Cache::put($languageAttributeKey, $response[$languageColumnName . "_" . strtolower($languageCode)]);
            }
        }
        return $response;
    }
}

if (!function_exists("getResponse")) {

    /**
     * @param array|bool $responseData
     * @param Carbon $startTime
     * @param bool $responseType
     * @param int $statusCode
     * @param string|null $message
     * @return array
     */
    function getResponse(array|bool|null $responseData, Carbon $startTime, bool $responseType, int $statusCode, string $message = null): array
    {
        $response = [];

        if(is_null($responseData)){
            $response['data'] = null;
        }

        if (!$responseType) {
            $response['order'] = request('order') ?? "ASC";
        }
        if (is_array($responseData) && !empty($responseData['data'])) {
            $response['current_page'] = $responseData['current_page'];
            $response['total_page'] = $responseData['last_page'];
            $response['page_size'] = $responseData['per_page'];
            $response['total'] = $responseData['total'];
        }
        if (is_array($responseData)) {
            $response['data'] = $responseData['data'] ?? $responseData;
        }
        $response['_response_status'] = [
            "success" => true,
            "code" => $statusCode,
        ];
        $response['_response_status']['message'] = $message;
        $response['_response_status']['query_time'] = $startTime->diffInSeconds(Carbon::now());
        return $response;
    }
}

if (!function_exists("bearerUserToken")) {

    function bearerUserToken(\Illuminate\Http\Request $request, $headerName = 'User-Token')
    {
        $header = $request->header($headerName);

        $position = strrpos($header, 'Bearer ');

        if ($position !== false) {
            $header = substr($header, $position + 7);
            return strpos($header, ',') !== false ? strstr(',', $header, true) : $header;
        }
    }
}


