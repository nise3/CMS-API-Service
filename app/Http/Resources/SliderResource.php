<?php

namespace App\Http\Resources;

use App\Models\BaseModel;
use App\Models\Faq;
use App\Models\Slider;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Slider $this */
        $response = [
            "id" => $this->id,
            "institute_id" => $this->institute_id,
            "organization_id" => $this->organization_id,
            "is_button_available" => $this->is_button_available,
            "link" => $this->link,
            "slider_images" => $this->slider_images,
        ];

        if ($request->offsetExists(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY) && $request->get(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY)) {
            $response['title'] = app(CmsLanguageService::class)->getLanguageValue($this, Slider::SLIDER_LANGUAGE_ATTR_TITLE);
            $response['sub_title'] = app(CmsLanguageService::class)->getLanguageValue($this, Slider::SLIDER_LANGUAGE_ATTR_SUB_TITLE);
            $response['button_text'] = app(CmsLanguageService::class)->getLanguageValue($this, Slider::SLIDER_LANGUAGE_ATTR_BUTTON_TEXT);
            $response['alt_title'] = app(CmsLanguageService::class)->getLanguageValue($this, Slider::SLIDER_LANGUAGE_ATTR_ALT_TITLE);
        } else {
            $response['institute_title'] = "";
            $response['institute_title_en'] = "";
            $response['organization_title'] = "";
            $response['organization_title_en'] = "";
            $response['title'] = $this->title;
            $response['sub_title'] = $this->sub_title;
            $response['alt_title'] = $this->alt_title;
            $response['button_text'] = $this->button_text;

            if (!$request->get(BaseModel::IS_COLLECTION_KEY)) {
                $response[BaseModel::OTHER_LANGUAGE_FIELDS_KEY] = CmsLanguageService::otherLanguageResponse($this->cmsLanguages);
            }
        }

        $response["banner_template"] = config("nise3.banner_template." . $this->banner_template_code);
        $response['row_status'] = $this->row_status;
        $response['created_by'] = $this->created_by;
        $response['updated_by'] = $this->updated_by;
        $response['created_at'] = $this->created_at;
        $response['updated_at'] = $this->updated_at;

        return $response;
    }
}
