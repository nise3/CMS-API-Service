<?php

namespace App\Http\Resources;

use App\Models\RecentActivity;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
        $languageCode = strtolower($request->server('HTTP_ACCEPT_LANGUAGE'));

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
        if (!empty(RecentActivity::RECENT_ACTIVITY_LANGUAGE_FILLABLE) && is_array(RecentActivity::RECENT_ACTIVITY_LANGUAGE_FILLABLE) && $languageCode && in_array($languageCode, LanguageCodeService::getLanguageCode())) {
            $tableName = $this->getTable();
            $keyId = $this->id;

            foreach (RecentActivity::RECENT_ACTIVITY_LANGUAGE_FILLABLE as $translatableKey) {
                $translatableValue = app(CmsLanguageService::class)->getLanguageValue($tableName, $keyId, $translatableKey);
                $response = array_merge($response, $translatableValue);
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
