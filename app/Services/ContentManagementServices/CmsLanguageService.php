<?php

namespace App\Services\ContentManagementServices;

use App\Models\CmsLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CmsLanguageService
{

    /**
     * @param string $tableName
     * @param int $keyId
     * @param string $languageColumnName
     * @return array
     */
    public function getLanguageValue(string $tableName, int $keyId, string $languageColumnName): array
    {
        $languageCode = request()->server('HTTP_ACCEPT_LANGUAGE');
        $response = [];
        $languageAttributeKey = getLanguageAttributeKey($tableName, $keyId, $languageCode, $languageColumnName);
        if (Cache::has($languageAttributeKey)) {
            $response[$languageColumnName . "_" . strtolower($languageCode)] = Cache::get($languageAttributeKey);
        } else {
            $cmsLanguageValue = $this->getLanguageValueByKeyId($tableName, $keyId, $languageCode, $languageColumnName);
            if ($cmsLanguageValue) {
                $response[$languageColumnName . "_" . strtolower($languageCode)] = $cmsLanguageValue;
                Cache::put($languageAttributeKey, $response[$languageColumnName . "_" . strtolower($languageCode)]);
            }
        }
        return $response;
    }

    /**
     * @param string $tableName
     * @param int $keyId
     * @param string $languageCode
     * @param string $languageColumnName
     * @return string
     */
    public static function getLanguageValueByKeyId(string $tableName, int $keyId, string $languageCode, string $languageColumnName): string
    {
        return CmsLanguage::where('table_name', $tableName)
                ->where('lang_code', strtoupper($languageCode))
                ->where('key_id', $keyId)->where('column_name', $languageColumnName)
                ->first()->column_value ?? "";
    }


    /**
     * @param array $data
     * @return bool
     */
    public function store(array $data): bool
    {
        $cmsLanguage = app(CmsLanguage::class);
        return CmsLanguage::insert($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createOrUpdate(array $data): mixed
    {
        return CmsLanguage::updateOrCreate(
            [
                "key_id" => $data['key_id'],
                "lang_code" => $data['lang_code'],
                "column_name" => $data['column_name']
            ],
            $data
        );
    }

    /**
     * @param array $data
     * @return bool
     */
    public function deleteLanguage(array $data): bool
    {
        return CmsLanguage::where('key_id', $data['key_id'])->where("lang_code", $data['lang_code'])->delete();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function languageFieldDeleteValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'key_id' => [
                "required",
                "integer",
                "exists:cms_languages,key_id"
            ],
            "lang_code" => [
                "required",
                "string",
                Rule::in(array_keys(config('languages.others')))
            ]
        ];
        return Validator::make($request->all(), $rules);
    }
}
