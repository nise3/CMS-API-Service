<?php

namespace App\Http\Resources;

use App\Models\Gallery;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $languageCode = strtolower($request->server('HTTP_ACCEPT_LANGUAGE'));
        $resource= parent::toArray($request);
        /** @var Gallery $this */
        if (isset($this::GALLERY_LANGUAGE_FILLABLE) && is_array($this::GALLERY_LANGUAGE_FILLABLE) && $languageCode && in_array($languageCode, LanguageCodeService::getLanguageCode())) {
            $tableName = $this->getTable();
            $keyId = $this->id;
            foreach ($this::GALLERY_LANGUAGE_FILLABLE as $translatableKey) {
                $translatableValue = app(CmsLanguageService::class)->getLanguageValue($tableName, $keyId, $translatableKey);
                $response = array_merge($response, $translatableValue);
            }
        }
        return $resource;
    }
}
