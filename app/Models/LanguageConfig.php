<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

class LanguageConfig extends BaseModel
{
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE;


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
        $nativeLanguageCode = Cache::rememberForever("native_language_code", function () use ($languageCode) {
            return self::where('is_native', BaseModel::IS_NATIVE_LANGUAGE_FLAG)->first()->code ?? BaseModel::DEFAULT_LANGUAGE_CODE;
        });
        return $languageCode == $nativeLanguageCode;
    }
}
