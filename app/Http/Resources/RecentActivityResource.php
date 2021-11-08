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
            'activity_date' => $this->activity_date,
            'published_at' => $this->published_at,
            'archived_at' => $this->archived_at,
            "institute_id" => $this->institute_id,
            "organization_id" => $this->organization_id,
            "industry_association_id" => $this->industry_association_id,
            "title" => $this->title,
            "content_type" => $this->content_type,
            "content_path" => $this->content_path,
            "embedded_url" => $this->embedded_url,
            "embedded_id" => $this->embedded_id,
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
            $response['institute_title'] = "";
            $response['institute_title_en'] = "";
            $response['industry_association_title'] = "";
            $response['industry_association_title_en'] = "";
            $response['organization_title'] = "";
            $response['organization_title_en'] = "";
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
