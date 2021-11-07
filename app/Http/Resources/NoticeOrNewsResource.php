<?php

namespace App\Http\Resources;

use App\Models\NoticeOrNews;
use App\Services\Common\LanguageCodeService;
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
        $languageCode = strtolower($request->server('HTTP_ACCEPT_LANGUAGE'));

        /** @var NoticeOrNews $this */
        $response = [
            "id" => $this->id,
            "type" => $this->type,
            "show_in" => $this->show_in,
            'published_at' => $this->published_at,
            'archived_at' => $this->archived_at,
            "title" => $this->title,
            "title_en" => $this->title_en,
            "institute_id" => $this->institute_id,
            "organization_id" => $this->organization_id,
            "industry_association_id" => $this->industry_association_id,
            "details" => $this->details,
            "details_en" => $this->details_en,
            "main_image_path" => $this->main_image_path,
            "grid_image_path" => $this->grid_image_path,
            "thumb_image_path" => $this->thumb_image_path,
            "image_alt_title_en" => $this->image_alt_title_en,
            "image_alt_title" => $this->image_alt_title,
            "file_path" => $this->file_path,
            "file_alt_title_en" => $this->file_alt_title_en,
            "file_alt_title" => $this->file_alt_title
        ];
        if (!empty(NoticeOrNews::NOTICE_OR_NEWS_LANGUAGE_FILLABLE) && is_array(NoticeOrNews::NOTICE_OR_NEWS_LANGUAGE_FILLABLE) && $languageCode && in_array($languageCode, LanguageCodeService::getLanguageCode())) {
            $tableName = $this->getTable();
            $keyId = $this->id;
            foreach (NoticeOrNews::NOTICE_OR_NEWS_LANGUAGE_FILLABLE as $translatableKey) {
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
