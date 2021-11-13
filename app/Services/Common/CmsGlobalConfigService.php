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
        $organizationIds = [];
        $instituteIds = [];
        $batchIds = [];
        $programIds = [];
        $titleResponse = [];
        $instituteClientUrl = clientUrl(BaseModel::INSTITUTE_URL_CLIENT_TYPE) . BaseModel::GET_INSTITUTE_TITLE_BY_ID__HTTP_CLIENT_ENDPOINT;
        $instituteClientUrlForBatchAndProgramTitle = clientUrl(BaseModel::INSTITUTE_URL_CLIENT_TYPE) . BaseModel::GET_BATCH_AND_PROGRAM_TITLE_BY_ID_HTTP_CLIENT_ENDPOINT;
        $organizationClientUrl = clientUrl(BaseModel::ORGANIZATION_CLIENT_URL_TYPE) . BaseModel::GET_ORGANIZATION_TITLE_BY_ID_HTTP_CLIENT_ENDPOINT;

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
                if (!empty($cmsDatum['batch_id'])) {
                    $batchIds[] = $cmsDatum['batch_id'];
                }
                if (!empty($cmsDatum['program_id'])) {
                    $programIds[] = $cmsDatum['program_id'];
                }
            }
        } else {
            if (!empty($cmsData['organization_id'])) {
                $organizationIds[] = $cmsData['organization_id'];
            }
            if (!empty($cmsData['institute_id'])) {
                $instituteIds[] = $cmsData['institute_id'];
            }
            if (!empty($cmsData['batch_id'])) {
                $batchIds[] = $cmsData['batch_id'];
            }
            if (!empty($cmsData['program_id'])) {
                $programIds[] = $cmsData['program_id'];
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

        /** Call to Institute Service for Batch and Program Title */
        if(($batchIds && count($batchIds) > 0) || ($programIds && count($programIds) > 0)){
            $batchProgramData = Http::withOptions([
                'verify' => config("nise3.should_ssl_verify"),
                'debug' => config('nise3.http_debug'),
                'timeout' => config("nise3.http_timeout")
            ])->post($instituteClientUrlForBatchAndProgramTitle, [
                "batch_ids" => $batchIds,
                "program_ids" => $programIds
            ])->throw(function ($response, $e) use ($instituteClientUrlForBatchAndProgramTitle) {
                Log::debug("Http/Curl call error. Destination:: " . $instituteClientUrlForBatchAndProgramTitle . ' and Response:: ' . json_encode($response));
                return $e;
            })
                ->json('data');

            $titleResponse = [
                BaseModel::BATCH_AND_PROGRAM_TITLE => $batchProgramData
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


        $titleResponse[BaseModel::INSTITUTE_SERVICE] = $instituteData;
        $titleResponse[BaseModel::ORGANIZATION_SERVICE] = $organizationData;
        return $titleResponse;
    }
}
