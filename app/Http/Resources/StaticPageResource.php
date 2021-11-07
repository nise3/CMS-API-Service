<?php

namespace App\Http\Resources;

use App\Models\StaticPage;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaticPageResource extends JsonResource
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

        /** @var StaticPage $this */
        $response = [
            "id" => $this->id,
            "content_type" => $this->content_type,
            "show_in" => $this->show_in,
            "industry_association_id" => $this->industry_association_id,
            "content_slug_or_id" => $this->content_slug_or_id,
            "institute_id" => $this->institute_id,
            "organization_id" => $this->organization_id,
            "title" => $this->title,
            "sub_title" => $this->sub_title,
            "contents" => $this->contents
        ];
        if (!empty(StaticPage::STATIC_PAGE_LANGUAGE_FILLABLE) && is_array(StaticPage::STATIC_PAGE_LANGUAGE_FILLABLE) && $languageCode && in_array($languageCode, LanguageCodeService::getLanguageCode())) {
            $tableName = $this->getTable();
            $keyId = $this->id;
            foreach (StaticPage::STATIC_PAGE_LANGUAGE_FILLABLE as $translatableKey) {
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
