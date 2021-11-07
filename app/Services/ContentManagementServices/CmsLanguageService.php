<?php

namespace App\Services\ContentManagementServices;

use App\Models\CmsLanguage;
use App\Services\Common\LanguageCodeService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\NoReturn;


class CmsLanguageService
{

    /**
     * @param JsonResource $model
     * @param string $languageColumnName
     * @return string
     */
    public function getLanguageValue(JsonResource $model, string $languageColumnName): string
    {
        $languageCode = strtolower(request()->server('HTTP_ACCEPT_LANGUAGE'));
        $response = "";
        $languageAttributeKey = getLanguageAttributeKey($model->getTable(), $model->id, $languageCode, $languageColumnName);
        if (Cache::has($languageAttributeKey)) {
            $response = Cache::get($languageAttributeKey);
        } else {
            $cmsLanguageValue = $this->getLanguageValueByKeyId($model->getTable(), $model->id, $languageCode, $languageColumnName);
            if ($cmsLanguageValue) {
                $response = $cmsLanguageValue;
                Cache::put($languageAttributeKey, $response);
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

    public static function otherLanguageResponse(Collection $cmsLanguage): array
    {
        $otherLanguage = [];
        /** @var CmsLanguage $language */
        foreach ($cmsLanguage as $language) {
            $indexKey = $language->lang_code;
            $column = $language->column_name;
            $otherLanguage[$indexKey][$column] = $language->column_value;
        }
        return $otherLanguage;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function store(array $data): bool
    {
        return CmsLanguage::insert($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createOrUpdate(array $data): CmsLanguage
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
        $cmsLanguage = CmsLanguage::where('key_id', $data['key_id'])->where("lang_code", $data['lang_code'])->first();
        $columnName = $cmsLanguage->column_name ?? "";
        $tableName = $cmsLanguage->table_name ?? "";
        self::languageCacheClearByKey($tableName, $data['key_id'], $data['lang_code'], $columnName);
        return CmsLanguage::where('key_id', $data['key_id'])->where("lang_code", $data['lang_code'])->delete();

    }

    /**
     * @param Model $model
     * @param string $languageCode
     * @param string $columnName
     * @return bool
     */
    public static function languageCacheClearByKey(string $tableName, int $keyId, string $languageCode, string $columnName): bool
    {
        $key = getLanguageAttributeKey($tableName, $keyId, $languageCode, $columnName);
        return Cache::forget($key);
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
