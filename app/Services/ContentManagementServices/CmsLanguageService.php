<?php

namespace App\Services\ContentManagementServices;

use App\Models\CmsLanguage;

class CmsLanguageService
{

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
}
