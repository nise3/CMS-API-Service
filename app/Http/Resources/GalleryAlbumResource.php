<?php

namespace App\Http\Resources;

use App\Models\GalleryAlbum;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
        $languageCode = strtolower($request->server('HTTP_ACCEPT_LANGUAGE'));

        /** @var GalleryAlbum $this */
        $response = [
            "id" => $this->id,
            "parent_gallery_album_id" => $this->parent_gallery_album_id,
            "featured" => $this->featured,
            "show_in" => $this->show_in,
            "album_type" => $this->album_type,
            'published_at' => $this->published_at,
            'archived_at' => $this->archived_at,
            "institute_id" => $this->institute_id,
            "organization_id" => $this->organization_id,
            "industry_association_id" => $this->industry_association_id,
            "batch_id" => $this->batch_id,
            "program_id" => $this->program_id,
            "title" => $this->title,
            "title_en" => $this->title_en,
            "main_image_path" => $this->main_image_path,
            "thumb_image_path" => $this->thumb_image_path,
            "grid_image_path" => $this->grid_image_path,
            "image_alt_title" => $this->image_alt_title,
            "image_alt_title_en" => $this->image_alt_title_en

        ];

        if (!empty(GalleryAlbum::GALLERY_ALBUM_LANGUAGE_FILLABLE) && is_array(GalleryAlbum::GALLERY_ALBUM_LANGUAGE_FILLABLE) && $languageCode && in_array($languageCode, LanguageCodeService::getLanguageCode())) {
            $tableName = $this->getTable();
            $keyId = $this->id;

            foreach (GalleryAlbum::GALLERY_ALBUM_LANGUAGE_FILLABLE as $translatableKey) {
                $translatableValue = app(CmsLanguageService::class)->getLanguageValue($tableName, $keyId, $translatableKey);
                $response = array_merge($response, $translatableValue);
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
