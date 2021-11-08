<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

class LanguageConfig extends BaseModel
{
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE;

    public const CONFIGURABLE_LANGUAGE_CODES_CACHE_KEY = "configurable_language_codes";
    public const NATIVE_LANGUAGE_CODES_CACHE_KEY = "native_language_code";


    /**
     * @param string $languageCode
     * @return bool
     */
    public static function isNative(string $languageCode): bool
    {
        if (!$languageCode) {
            return true;
        }
        //TODO: need to flush after updating native flag
        $nativeLanguageCode = Cache::rememberForever(self::NATIVE_LANGUAGE_CODES_CACHE_KEY, function () use ($languageCode) {
            return self::where('is_native', BaseModel::IS_NATIVE_LANGUAGE_FLAG)->first()->code ?? BaseModel::DEFAULT_LANGUAGE_CODE;
        });
        return $languageCode == $nativeLanguageCode;
    }


}
