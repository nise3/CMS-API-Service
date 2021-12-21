<?php

namespace App\Http\Resources;

use App\Models\BaseModel;
use App\Models\GalleryImageVideo;
use App\Services\ContentManagementServices\CmsLanguageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryImageVideoResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var GalleryImageVideo $this */
        $response = [
            "id" => $this->id,
            "gallery_album_id" => $this->gallery_album_id,
            "gallery_album_title" => $this->gallery_album_title,
            "featured" => $this->featured,
            'published_at' => $this->published_at,
            'archived_at' => $this->archived_at,
            "institute_id" => $this->institute_id,
            "organization_id" => $this->organization_id,
            "industry_association_id" => $this->industry_association_id,
            "institute_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INSTITUTE_SERVICE][$this->institute_id]['title'] ?? "",
            "institute_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INSTITUTE_SERVICE][$this->institute_id]['title_en'] ?? "",
            "organization_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::ORGANIZATION_SERVICE][$this->organization_id]['title'] ?? "",
            "organization_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::ORGANIZATION_SERVICE][$this->organization_id]['title_en'] ?? "",
            "industry_association_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INDUSTRY_ASSOCIATION_TITLE][$this->industry_association_id]['title'] ?? "",
            "industry_association_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INDUSTRY_ASSOCIATION_TITLE][$this->industry_association_id]['title_en'] ?? "",
            "content_type" => $this->content_type,
            "video_type" => $this->video_type,
            "title" => $this->title,
            "description" => $this->description,
            "image_path" => $this->image_path,
            "video_url" => $this->video_url,
            "video_id" => $this->video_id,
            "content_properties_json" => $this->content_properties_json,
            "content_grid_image_path" => $this->content_grid_image_path,
            "content_thumb_image_path" => $this->content_thumb_image_path,
            "image_alt_title" => $this->image_alt_title,
        ];
        if ($request->offsetExists(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY) && $request->get(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY)) {
            $response['title'] = app(CmsLanguageService::class)->getLanguageValue($this, GalleryImageVideo::LANGUAGE_ATTR_TITLE);
            $response['description'] = app(CmsLanguageService::class)->getLanguageValue($this, GalleryImageVideo::LANGUAGE_ATTR_DESCRIPTION);
            $response['image_alt_title'] = app(CmsLanguageService::class)->getLanguageValue($this, GalleryImageVideo::LANGUAGE_ATTR_IMAGE_ALT_TITLE);
        } else {
            $response['title'] = $this->title;
            $response['description'] = $this->description;
            $response['image_alt_title'] = $this->image_alt_title;
            if (!$request->get(BaseModel::IS_COLLECTION_KEY)) {
                $response[BaseModel::OTHER_LANGUAGE_FIELDS_KEY] = CmsLanguageService::otherLanguageResponse($this);
            }
        }

        $response['row_status'] = $this->row_status;
        $response['published_by'] = $this->published_by;
        $response['archived_by'] = $this->archived_by;
        $response['created_by'] = $this->created_by;
        $response['updated_by'] = $this->updated_by;
        $response['created_at'] = $this->created_at;
        $response['updated_at'] = $this->updated_at;

        return $response;
    }
}
