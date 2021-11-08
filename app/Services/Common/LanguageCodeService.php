<?php

namespace App\Services\Common;

use App\Models\BaseModel;
use App\Models\LanguageCode;
use App\Models\LanguageConfig;
use Illuminate\Support\Facades\Cache;

class LanguageCodeService
{

    /**
     * @return array
     */
    public static function getLanguageCode(): array
    {
        return Cache::rememberForever(LanguageConfig::CONFIGURABLE_LANGUAGE_CODES_CACHE_KEY, function () {
            return LanguageConfig::where('is_native', '<>', BaseModel::IS_NATIVE_LANGUAGE_FLAG)->pluck("code")->toArray();
        });
    }


}
