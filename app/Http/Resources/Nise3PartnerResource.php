<?php

namespace App\Http\Resources;

use App\Models\BaseModel;
use App\Models\Nise3Partner;
use App\Services\ContentManagementServices\CmsLanguageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Nise3PartnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Nise3Partner $this */
        $response = [
            "id" => $this->id,
            "title" => $this->title,
            "main_image_path" => $this->main_image_path,
            "thumb_image_path" => $this->thumb_image_path,
            "grid_image_path" => $this->grid_image_path,
            "domain" => $this->domain,
            "image_alt_title" => $this->image_alt_title,
        ];

        if ($request->offsetExists(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY) && $request->get(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY)) {
            $response['title'] = app(CmsLanguageService::class)->getLanguageValue($this, Nise3Partner::NISE_3_PARTNER_TITLE);
            $response['image_alt_title'] = app(CmsLanguageService::class)->getLanguageValue($this, Nise3Partner::NISE_3_PARTNER_ATL_IMAGE);
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
