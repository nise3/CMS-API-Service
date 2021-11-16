<?php

namespace App\Http\Resources;

use App\Models\BaseModel;
use App\Models\GalleryAlbum;
use App\Services\ContentManagementServices\CmsLanguageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class GalleryAlbumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var GalleryAlbum $this */
        $response = [
            "id" => $this->id,
            "parent_gallery_album_id" => $this->parent_gallery_album_id,
            "parent_gallery_album_title" => $this->parent_gallery_album_title,
            "featured" => $this->featured,
            "show_in" => $this->show_in,
            "show_in_label" => BaseModel::SHOW_INS[$this->show_in],
            "album_type" => $this->album_type,
            'published_at' => $this->published_at,
            'archived_at' => $this->archived_at,
            "institute_id" => $this->institute_id,
            "institute_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INSTITUTE_SERVICE][$this->institute_id]['title'] ?? "",
            "institute_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INSTITUTE_SERVICE][$this->institute_id]['title_en'] ?? "",
            "organization_id" => $this->organization_id,
            "organization_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::ORGANIZATION_SERVICE][$this->organization_id]['title'] ?? "",
            "organization_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::ORGANIZATION_SERVICE][$this->organization_id]['title_en'] ?? "",
            "industry_association_id" => $this->industry_association_id,
            "course_id" => $this->course_id,
            "course_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::COURSE_AND_PROGRAM_TITLE][BaseModel::COURSE_TITLE][$this->course_id]['title'] ?? "",
            "course_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::COURSE_AND_PROGRAM_TITLE][BaseModel::COURSE_TITLE][$this->course_id]['title_en'] ?? "",
            "program_id" => $this->program_id,
            "program_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::COURSE_AND_PROGRAM_TITLE][BaseModel::PROGRAM_TITLE][$this->program_id]['title'] ?? "",
            "program_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::COURSE_AND_PROGRAM_TITLE][BaseModel::PROGRAM_TITLE][$this->program_id]['title_en'] ?? "",
            "main_image_path" => $this->main_image_path,
            "thumb_image_path" => $this->thumb_image_path,
            "grid_image_path" => $this->grid_image_path,
            "gallery_images_videos" => $this->galleryImagesVideos,

        ];
        if ($request->offsetExists(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY) && $request->get(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY)) {
            $response['title'] = app(CmsLanguageService::class)->getLanguageValue($this, GalleryAlbum::LANGUAGE_ATTR_TITLE);
            $response['image_alt_title'] = app(CmsLanguageService::class)->getLanguageValue($this, GalleryAlbum::LANGUAGE_ATTR_IMAGE_ALT_TITLE);
        } else {
            $response['title'] = $this->title;
            $response['image_alt_title'] = $this->image_alt_title;
            if (!$request->get(BaseModel::IS_COLLECTION_KEY)) {
                $response[BaseModel::OTHER_LANGUAGE_FIELDS_KEY] = CmsLanguageService::otherLanguageResponse($this);
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
