<?php

namespace App\Services\Common;

use App\Models\BaseModel;
use App\Models\LanguageConfig;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\ArrayShape;

class CmsGlobalConfigService
{
    /**
     * @return array
     */
    #[ArrayShape(["language_configs" => "\App\Models\LanguageConfig[]|\Illuminate\Database\Eloquent\Collection", "banner_templates" => "\Laravel\Lumen\Application|mixed", "show_in" => "\Laravel\Lumen\Application|mixed"])]
    public function getGlobalConfigList(): array
    {
        $languageConfig = LanguageConfig::all();
        return [
            "language_configs" => $languageConfig,
            "banner_templates" => config('nise3.banner_template'),
            "show_in" => array_values(config('nise3.show_in'))
        ];
    }

    /**
     * @param array $cmsData
     * @return array
     * @throws RequestException
     */

    #[ArrayShape([BaseModel::INSTITUTE_SERVICE => "array|mixed", BaseModel::ORGANIZATION_SERVICE => "array|mixed"])]
    public static function getOrganizationOrInstituteOrIndustryAssociationTitle(array $cmsData): array
    {
        $industryAssociationIds = [];
        $organizationIds = [];
        $instituteIds = [];
        $courseIds = [];
        $programIds = [];
        $titleResponse = [];
        $instituteClientUrl = clientUrl(BaseModel::INSTITUTE_URL_CLIENT_TYPE) . BaseModel::GET_INSTITUTE_TITLE_BY_ID__HTTP_CLIENT_ENDPOINT;
        $instituteClientUrlForCourseAndProgramTitle = clientUrl(BaseModel::INSTITUTE_URL_CLIENT_TYPE) . BaseModel::GET_COURSE_AND_PROGRAM_TITLE_BY_ID_HTTP_CLIENT_ENDPOINT;
        $organizationClientUrl = clientUrl(BaseModel::ORGANIZATION_CLIENT_URL_TYPE) . BaseModel::GET_ORGANIZATION_TITLE_BY_ID_HTTP_CLIENT_ENDPOINT;
        $organizationClientUrlForIndustryAssociationTitle = clientUrl(BaseModel::ORGANIZATION_CLIENT_URL_TYPE) . BaseModel::GET_INDUSTRY_ASSOCIATION_TITLE_BY_ID_HTTP_CLIENT_ENDPOINT;

        /**
         * For get_list request execute IF block.
         * Otherwise, for single get/read execute ELSE block.
         */
        if (empty($cmsData['id'])) {
            foreach ($cmsData as $cmsDatum) {
                if (!empty($cmsDatum['organization_id'])) {
                    $organizationIds[] = $cmsDatum['organization_id'];
                }
                if (!empty($cmsDatum['institute_id'])) {
                    $instituteIds[] = $cmsDatum['institute_id'];
                }
                if (!empty($cmsDatum['course_id'])) {
                    $courseIds[] = $cmsDatum['course_id'];
                }
                if (!empty($cmsDatum['program_id'])) {
                    $programIds[] = $cmsDatum['program_id'];
                }
                if (!empty($cmsDatum['industry_association_id'])) {
                    $industryAssociationIds[] = $cmsDatum['industry_association_id'];
                }
            }
        } else {
            if (!empty($cmsData['organization_id'])) {
                $organizationIds[] = $cmsData['organization_id'];
            }
            if (!empty($cmsData['institute_id'])) {
                $instituteIds[] = $cmsData['institute_id'];
            }
            if (!empty($cmsData['course_id'])) {
                $courseIds[] = $cmsData['course_id'];
            }
            if (!empty($cmsData['program_id'])) {
                $programIds[] = $cmsData['program_id'];
            }
            if (!empty($cmsData['industry_association_id'])) {
                $industryAssociationIds[] = $cmsData['industry_association_id'];
            }
        }


        /** Call to Institute Service for Institute Title */
        $instituteData = Http::withOptions([
            'verify' => config("nise3.should_ssl_verify"),
            'debug' => config('nise3.http_debug'),
            'timeout' => config("nise3.http_timeout")
        ])->post($instituteClientUrl, [
            "institute_ids" => $instituteIds
        ])->throw(function ($response, $e) use ($instituteClientUrl) {
            Log::debug("Http/Curl call error. Destination:: " . $instituteClientUrl . ' and Response:: ' . json_encode($response));
            return $e;
        })
            ->json('data');

        /** Call to Institute Service for Course and Program Title */
        if (($courseIds && count($courseIds) > 0) || ($programIds && count($programIds) > 0)) {
            $courseProgramData = Http::withOptions([
                'verify' => config("nise3.should_ssl_verify"),
                'debug' => config('nise3.http_debug'),
                'timeout' => config("nise3.http_timeout")
            ])->post($instituteClientUrlForCourseAndProgramTitle, [
                "course_ids" => $courseIds,
                "program_ids" => $programIds
            ])->throw(function ($response, $e) use ($instituteClientUrlForCourseAndProgramTitle) {
                Log::debug("Http/Curl call error. Destination:: " . $instituteClientUrlForCourseAndProgramTitle . ' and Response:: ' . json_encode($response));
                return $e;
            })
                ->json('data');

            $titleResponse = [
                BaseModel::COURSE_AND_PROGRAM_TITLE => $courseProgramData
            ];
        }

        /** Call to Organization Service for Organization Title */
        $organizationData = Http::withOptions([
            'verify' => config("nise3.should_ssl_verify"),
            'debug' => config('nise3.http_debug'),
            'timeout' => config("nise3.http_timeout")
        ])->post($organizationClientUrl, [
            "organization_ids" => $organizationIds
        ])->throw(function ($response, $e) use ($organizationClientUrl) {
            Log::debug("Http/Curl call error. Destination:: " . $organizationClientUrl . ' and Response:: ' . json_encode($response));
            return $e;
        })->json('data');

        /** Call to Organization Service for Industry Association Title & Title EN */
        if ($industryAssociationIds) {
            $industryAssociationData = Http::withOptions([
                'verify' => config("nise3.should_ssl_verify"),
                'debug' => config('nise3.http_debug'),
                'timeout' => config("nise3.http_timeout")
            ])->post($organizationClientUrlForIndustryAssociationTitle, [
                "industry_association_ids" => $industryAssociationIds
            ])->throw(function ($response, $e) use ($organizationClientUrlForIndustryAssociationTitle) {
                Log::debug("Http/Curl call error. Destination:: " . $organizationClientUrlForIndustryAssociationTitle . ' and Response:: ' . json_encode($response));
                return $e;
            })->json('data');

            $titleResponse[BaseModel::INDUSTRY_ASSOCIATION_TITLE] = $industryAssociationData;
        }

        $titleResponse[BaseModel::INSTITUTE_SERVICE] = $instituteData;
        $titleResponse[BaseModel::ORGANIZATION_SERVICE] = $organizationData;
        return $titleResponse;
    }
}
