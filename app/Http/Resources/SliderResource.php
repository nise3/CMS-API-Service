<?php

namespace App\Http\Resources;

use App\Models\Banner;
use App\Models\BaseModel;
use App\Models\Slider;
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
            "show_in" => $this->show_in,
            "title" => $this->title,
            "show_in_label" => BaseModel::SHOW_INS[$this->show_in],
            "industry_association_id" => $this->industry_association_id,
            "institute_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INSTITUTE_SERVICE][$this->institute_id]['title'] ?? "",
            "institute_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INSTITUTE_SERVICE][$this->institute_id]['title_en'] ?? "",
            "organization_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::ORGANIZATION_SERVICE][$this->organization_id]['title'] ?? "",
            "organization_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::ORGANIZATION_SERVICE][$this->organization_id]['title_en'] ?? "",
            "institute_id" => $this->institute_id,
            "organization_id" => $this->organization_id,
        ];

        if ($request->offsetExists(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY) && $request->get(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY)) {
            $response['banners'] = $this->banners;

            /** Change Banners Language Fillable fields value as per ACCEPT_LANGUAGE header field value */
            if($this->banners && is_array(json_decode(json_encode($this->banners))) && count(json_decode(json_encode($this->banners))) > 0){
                foreach ($response['banners'] as $banner){
                    if(!empty($banner->title)){
                        $banner->title = app(CmsLanguageService::class)->getLanguageValue(new BannerResource($banner), Banner::BANNER_LANGUAGE_ATTR_TITLE);
                    }
                    if(!empty($banner->sub_title)){
                        $banner->sub_title = app(CmsLanguageService::class)->getLanguageValue(new BannerResource($banner), Banner::BANNER_LANGUAGE_ATTR_SUB_TITLE);
                    }
                    if(!empty($banner->alt_image_title)){
                        $banner->alt_image_title = app(CmsLanguageService::class)->getLanguageValue(new BannerResource($banner), Banner::BANNER_LANGUAGE_ATTR_ALT_IMAGE_TITLE);
                    }
                    if(!empty($banner->button_text)){
                        $banner->button_text = app(CmsLanguageService::class)->getLanguageValue(new BannerResource($banner), Banner::BANNER_LANGUAGE_ATTR_BUTTON_TEXT);
                    }
                }
            }
        }

        $response['row_status'] = $this->row_status;
        $response['created_by'] = $this->created_by;
        $response['updated_by'] = $this->updated_by;
        $response['created_at'] = $this->created_at;
        $response['updated_at'] = $this->updated_at;

        return $response;
    }
}
