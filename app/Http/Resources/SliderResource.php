<?php

namespace App\Http\Resources;

use App\Models\BaseModel;
use App\Models\Slider;
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
        }

        $response['row_status'] = $this->row_status;
        $response['created_by'] = $this->created_by;
        $response['updated_by'] = $this->updated_by;
        $response['created_at'] = $this->created_at;
        $response['updated_at'] = $this->updated_at;

        return $response;
    }
}
