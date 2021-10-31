<?php

namespace App\Services\Common;

use App\Models\LanguageCode;
use Illuminate\Support\Facades\Cache;

class LanguageCodeService
{

    /**
     * @return array
     */
    public static function getLanguageCode(): array
    {
        return Cache::rememberForever("language_codes", function () {
            return LanguageCode::pluck("code")->toArray();
        });
    }

}
