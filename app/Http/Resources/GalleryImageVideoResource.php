<?php

namespace App\Http\Resources;

use App\Models\BaseModel;
use App\Models\GalleryImageVideo;
use App\Services\Common\LanguageCodeService;
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
            "featured" => $this->featured,
            'published_at' => $this->published_at,
            'archived_at' => $this->archived_at,
            "institute_id" => $this->institute_id,
            "organization_id" => $this->organization_id,
            "industry_association_id" => $this->industry_association_id,
            "content_type" => $this->content_type,
            "video_type" => $this->video_type,
            "content_title" => $this->content_title,
            "content_description" => $this->content_description,
            "image_url" => $this->image_url,
            "video_url" => $this->video_url,
            "content_properties_json" => $this->content_properties_json,
            "content_cover_image_url" => $this->content_cover_image_url,
            "content_grid_image_url" => $this->content_thumb_image_url,
            "alt_title" => $this->alt_title,
        ];
        if ($request->offsetExists(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY) && $request->get(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY)) {
            $response['content_title'] = app(CmsLanguageService::class)->getLanguageValue($this, GalleryImageVideo::LANGUAGE_ATTR_CONTENT_TITLE);
            $response['content_description'] = app(CmsLanguageService::class)->getLanguageValue($this, GalleryImageVideo::LANGUAGE_ATTR_CONTENT_DESCRIPTION);
            $response['alt_title'] = app(CmsLanguageService::class)->getLanguageValue($this, GalleryImageVideo::LANGUAGE_ATTR_ALT_TITLE);
        } else {
            $response['institute_title'] = "";
            $response['institute_title_en'] = "";
            $response['industry_association_title'] = "";
            $response['industry_association_title_en'] = "";
            $response['organization_title'] = "";
            $response['organization_title_en'] = "";
            $response['content_title'] = $this->content_title;
            $response['content_description'] = $this->content_description;
            $response['alt_title'] = $this->alt_title;
            if (!$request->get(BaseModel::IS_COLLECTION_KEY)) {
                $response[BaseModel::OTHER_LANGUAGE_FIELDS_KEY] = CmsLanguageService::otherLanguageResponse($this->cmsLanguages);
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
