<?php

namespace App\Http\Resources;

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
        $languageCode = strtolower($request->server('HTTP_ACCEPT_LANGUAGE'));

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
            "content_title_en" => $this->content_title_en,
            "content_description" => $this->content_description,
            "content_description_en" => $this->content_description_en,
            "image_url" => $this->image_url,
            "video_url" => $this->video_url,
            "content_properties_json" => $this->content_properties_json,
            "content_cover_image_url" => $this->content_cover_image_url,
            "content_grid_image_url" => $this->content_thumb_image_url,
            "alt_title" => $this->alt_title,
            "alt_title_en" => $this->alt_title_en
        ];

        if (!empty(GalleryImageVideo::GALLERY_IMAGE_VIDEO_LANGUAGE_FILLABLE) && is_array(GalleryImageVideo::GALLERY_IMAGE_VIDEO_LANGUAGE_FILLABLE) && $languageCode && in_array($languageCode, LanguageCodeService::getLanguageCode())) {
            $tableName = $this->getTable();
            $keyId = $this->id;
            foreach (GalleryImageVideo::GALLERY_IMAGE_VIDEO_LANGUAGE_FILLABLE as $translatableKey) {
                $translatableValue = app(CmsLanguageService::class)->getLanguageValue($tableName, $keyId, $translatableKey);
                $response = array_merge($response, $translatableValue);
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
