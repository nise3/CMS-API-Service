<?php

namespace App\Http\Resources;

use App\Models\Slider;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
        /** @var Slider $this */
        $response=[
            "id"=>$this->id,
            "institute_id"=>$this->institute_id,
            "organization_id"=>$this->organization_id,
            "title"=>$this->title,
            "title_en"=>$this->title_en,
            "sub_title"=>$this->sub_title,
            "sub_title_en"=>$this->sub_title_en,
            "is_button_available"=>$this->is_button_available,
            "button_text"=>$this->button_text,
            "link"=>$this->link,
            "slider_images"=>$this->slider_images,
            "alt_title"=>$this->alt_title,
            "alt_title_en"=>$this->alt_title_en
        ];

        if (!empty($this::SLIDER_LANGUAGE_FIELDS) && is_array($this::SLIDER_LANGUAGE_FIELDS) && $languageCode && in_array($languageCode, LanguageCodeService::getLanguageCode())) {
            $tableName = $this->getTable();
            $keyId = $this->id;

            foreach ($this::SLIDER_LANGUAGE_FIELDS as $translatableKey) {
                $translatableValue = app(CmsLanguageService::class)->getLanguageValue($tableName, $keyId, $translatableKey);
                $response = array_merge($response, $translatableValue);
            }
        }
        return $response;
    }
}
