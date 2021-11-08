<?php

namespace App\Services\Common;

use App\Models\LanguageConfig;
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
            "show_in"=>array_values(config('nise3.show_in'))
        ];
    }
}
