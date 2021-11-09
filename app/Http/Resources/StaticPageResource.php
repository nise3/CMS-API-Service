<?php

namespace App\Http\Resources;

use App\Models\BaseModel;
use App\Models\StaticPage;
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
        /** @var StaticPage $this */
        $response = [
            "id" => $this->id,
            "content_type" => $this->content_type,
            "show_in" => $this->show_in,
            "show_in_label" => BaseModel::SHOW_INS[$this->show_in],
            "industry_association_id" => $this->industry_association_id,
            "content_slug_or_id" => $this->content_slug_or_id,
            "institute_id" => $this->institute_id,
            "organization_id" => $this->organization_id,
            "title" => $this->title,
            "sub_title" => $this->sub_title,
            "contents" => $this->contents
        ];

        if ($request->offsetExists(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY) && $request->get(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY)) {
            $response['title'] = app(CmsLanguageService::class)->getLanguageValue($this, StaticPage::LANGUAGE_ATTR_TITLE);
            $response['sub_title'] = app(CmsLanguageService::class)->getLanguageValue($this, StaticPage::LANGUAGE_ATTR_SUB_TITLE);
            $response['contents'] = app(CmsLanguageService::class)->getLanguageValue($this, StaticPage::LANGUAGE_ATTR_CONTENTS);
        } else {
            $response['institute_title'] = "";
            $response['institute_title_en'] = "";
            $response['industry_association_title'] = "";
            $response['industry_association_title_en'] = "";
            $response['organization_title'] = "";
            $response['organization_title_en'] = "";
            $response['title'] = $this->title;
            $response['sub_title'] = $this->sub_title;
            $response['contents'] = $this->contents;
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
