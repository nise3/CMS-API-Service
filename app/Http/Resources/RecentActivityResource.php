<?php

namespace App\Http\Resources;

use App\Models\BaseModel;
use App\Models\RecentActivity;
use App\Services\ContentManagementServices\CmsLanguageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class RecentActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var RecentActivity $this */
        $response = [
            "id" => $this->id,
            "show_in" => $this->show_in,
            "show_in_label" => BaseModel::SHOW_INS[$this->show_in],
            'activity_date' => $this->activity_date,
            'published_at' => $this->published_at,
            'archived_at' => $this->archived_at,
            "institute_id" => $this->institute_id,
            "organization_id" => $this->organization_id,
            "institute_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INSTITUTE_SERVICE][$this->institute_id]['title'] ?? "",
            "institute_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INSTITUTE_SERVICE][$this->institute_id]['title_en'] ?? "",
            "organization_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::ORGANIZATION_SERVICE][$this->organization_id]['title'] ?? "",
            "organization_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::ORGANIZATION_SERVICE][$this->organization_id]['title_en'] ?? "",
            "industry_association_id" => $this->industry_association_id,
            "title" => $this->title,
            "content_type" => $this->content_type,
            "image_path" => $this->image_path,
            "video_url" => $this->video_url,
            "video_id" => $this->video_id,
            "content_properties" => $this->content_properties,

            "collage_image_path" => $this->collage_image_path,
            "collage_position" => $this->collage_position,
            "thumb_image_path" => $this->thumb_image_path,
            "grid_image_path" => $this->grid_image_path,

            "image_alt_title" => $this->image_alt_title,
            "description" => $this->description,
        ];

        if ($request->offsetExists(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY) && $request->get(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY)) {
            $response['title'] = app(CmsLanguageService::class)->getLanguageValue($this, RecentActivity::LANGUAGE_ATTR_TITLE);
            $response['image_alt_title'] = app(CmsLanguageService::class)->getLanguageValue($this, RecentActivity::LANGUAGE_ATTR_IMAGE_ALT_TITLE);
            $response['description'] = app(CmsLanguageService::class)->getLanguageValue($this, RecentActivity::LANGUAGE_ATTR_DESCRIPTION);
        } else {
            $response['title'] = $this->title;
            $response['image_alt_title'] = $this->image_alt_title;
            $response['description'] = $this->description;
            if (!$request->get(BaseModel::IS_COLLECTION_KEY)) {
                $response[BaseModel::OTHER_LANGUAGE_FIELDS_KEY] = CmsLanguageService::otherLanguageResponse($this);
            }
        }

        $response['row_status'] = $this->row_status;
        $response['published_by'] = $this->published_by;
        $response['archived_by'] = $this->archived_by;
        $response['updated_by'] = $this->updated_by;
        $response['updated_by'] = $this->updated_by;
        $response['created_at'] = $this->created_at;
        $response['updated_at'] = $this->updated_at;


        return $response;
    }
}
