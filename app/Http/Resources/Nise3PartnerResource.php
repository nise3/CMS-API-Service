<?php

namespace App\Http\Resources;

use App\Models\Nise3Partner;
use App\Models\Slider;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use Illuminate\Http\Resources\Json\JsonResource;

class Nise3PartnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Nise3Partner $this */
        $response=[
            "id"=>$this->id,
            "title_en"=>$this->title_en,
            "title"=>$this->title,
            "main_image_path"=>$this->main_image_path,
            "thumb_image_path"=>$this->thumb_image_path,
            "grid_image_path"=>$this->grid_image_path,
            "domain"=>$this->domain,
            "image_alt_title_en"=>$this->image_alt_title_en,
            "image_alt_title"=>$this->image_alt_title,
        ];

        $languageCode = strtolower($request->server('HTTP_ACCEPT_LANGUAGE'));
        if (!empty(Nise3Partner::NISE_3_PARTNER_LANGUAGE_FIELDS) && is_array(Nise3Partner::NISE_3_PARTNER_LANGUAGE_FIELDS) && $languageCode && in_array($languageCode, LanguageCodeService::getLanguageCode())) {
            $tableName = $this->getTable();
            $keyId = $this->id;
            foreach (Nise3Partner::NISE_3_PARTNER_LANGUAGE_FIELDS as $translatableKey) {
                $translatableValue = app(CmsLanguageService::class)->getLanguageValue($tableName, $keyId, $translatableKey);
                $response = array_merge($response, $translatableValue);
            }
        }

        $response['row_status'] = $this->row_status;
        $response['created_by'] = $this->created_by;
        $response['updated_by'] = $this->updated_by;
        $response['created_at'] = $this->created_at;
        $response['updated_at'] = $this->updated_at;
    }
}
