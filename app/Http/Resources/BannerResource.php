<?php

namespace App\Http\Resources;

use App\Models\BaseModel;
use App\Models\Banner;
use App\Services\ContentManagementServices\CmsLanguageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Banner $this */
        $response = [
            "id" => $this->id,
            "is_button_available" => $this->is_button_available,
            "link" => $this->link,
            "slider_id" => $this->slider_id,
            "banner_template_code" => $this->banner_template_code,
            "banner_image_url" => $this->banner_image_url,
            "institute_id"=>$this->institute_id,
            "organization_id"=>$this->organization_id,
            "industry_association_id"=>$this->industry_association_id,
            "institute_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INSTITUTE_SERVICE][$this->institute_id]['title'] ?? "",
            "institute_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INSTITUTE_SERVICE][$this->institute_id]['title_en'] ?? "",
            "organization_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::ORGANIZATION_SERVICE][$this->organization_id]['title'] ?? "",
            "organization_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::ORGANIZATION_SERVICE][$this->organization_id]['title_en'] ?? "",
        ];

        if ($request->offsetExists(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY) && $request->get(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY)) {
            $response['title'] = app(CmsLanguageService::class)->getLanguageValue($this, Banner::BANNER_LANGUAGE_ATTR_TITLE);
            $response['sub_title'] = app(CmsLanguageService::class)->getLanguageValue($this, Banner::BANNER_LANGUAGE_ATTR_SUB_TITLE);
            $response['button_text'] = app(CmsLanguageService::class)->getLanguageValue($this, Banner::BANNER_LANGUAGE_ATTR_BUTTON_TEXT);
            $response['alt_image_title'] = app(CmsLanguageService::class)->getLanguageValue($this, Banner::BANNER_LANGUAGE_ATTR_ALT_IMAGE_TITLE);
        } else {
            $response['title'] = $this->title;
            $response['sub_title'] = $this->sub_title;
            $response['alt_image_title'] = $this->alt_image_title;
            $response['button_text'] = $this->button_text;

            if (!$request->get(BaseModel::IS_COLLECTION_KEY)) {
                $response[BaseModel::OTHER_LANGUAGE_FIELDS_KEY] = CmsLanguageService::otherLanguageResponse($this);
            }
        }

        $response["banner_template_code"] = $this->banner_template_code;
        $response["banner_template"] = config("nise3.banner_template." . $this->banner_template_code);
        $response['row_status'] = $this->row_status;
        $response['created_by'] = $this->created_by;
        $response['updated_by'] = $this->updated_by;
        $response['created_at'] = $this->created_at;
        $response['updated_at'] = $this->updated_at;

        return $response;
    }
}
