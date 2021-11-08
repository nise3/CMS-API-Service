<?php

namespace App\Http\Resources;

use App\Models\BaseModel;
use App\Models\NoticeOrNews;
use App\Services\ContentManagementServices\CmsLanguageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticeOrNewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var NoticeOrNews $this */
        $response = [
            "id" => $this->id,
            "type" => $this->type,
            "show_in" => $this->show_in,
            'published_at' => $this->published_at,
            'archived_at' => $this->archived_at,
            "title" => $this->title,
            "institute_id" => $this->institute_id,
            "organization_id" => $this->organization_id,
            "industry_association_id" => $this->industry_association_id,
            "details" => $this->details,
            "main_image_path" => $this->main_image_path,
            "grid_image_path" => $this->grid_image_path,
            "thumb_image_path" => $this->thumb_image_path,
            "image_alt_title" => $this->image_alt_title,
            "file_path" => $this->file_path,
            "file_alt_title" => $this->file_alt_title
        ];

        if ($request->offsetExists(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY) && $request->get(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY)) {
            $response['title'] = app(CmsLanguageService::class)->getLanguageValue($this, NoticeOrNews::LANGUAGE_ATTR_TITLE);
            $response['details'] = app(CmsLanguageService::class)->getLanguageValue($this, NoticeOrNews::LANGUAGE_ATTR_DETAILS);
            $response['image_alt_title'] = app(CmsLanguageService::class)->getLanguageValue($this, NoticeOrNews::LANGUAGE_ATTR_IMAGE_ALT_TITLE);
            $response['file_alt_title'] = app(CmsLanguageService::class)->getLanguageValue($this, NoticeOrNews::LANGUAGE_ATTR_FILE_ALT_TITLE);
        } else {
            $response['institute_title'] = "";
            $response['institute_title_en'] = "";
            $response['industry_association_title'] = "";
            $response['industry_association_title_en'] = "";
            $response['organization_title'] = "";
            $response['organization_title_en'] = "";
            $response['title'] = $this->title;
            $response['details'] = $this->details;
            $response['image_alt_title'] = $this->image_alt_title;
            $response['file_alt_title'] = $this->file_alt_title;
            if (!$request->get(BaseModel::IS_COLLECTION_KEY)) {
                $response[BaseModel::OTHER_LANGUAGE_FIELDS_KEY] = CmsLanguageService::otherLanguageResponse($this->cmsLanguages);
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
