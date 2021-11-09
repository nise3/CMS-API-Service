<?php

namespace App\Services\Common;

use App\Models\BaseModel;
use App\Models\LanguageConfig;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\ArrayShape;

class CmsGlobalConfigService
{
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

    public static function getOrganizationOrInstituteOrIndustryAssociationTitle(array $cmsData): array
    {
        $organizationIds = [];
        $instituteIds = [];
        $instituteClientUrl = clientUrl(BaseModel::INSTITUTE_URL_CLIENT_TYPE);
        $organizationClientUrl = clientUrl(BaseModel::ORGANIZATION_CLIENT_URL_TYPE);

        foreach ($cmsData as $cmsDatum) {
            $organizationIds[] = $cmsDatum->organization_id;
            $instituteIds[] = $cmsDatum->institute_id;
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

    }
}
