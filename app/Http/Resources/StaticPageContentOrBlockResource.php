<?php

namespace App\Http\Resources;

use App\Models\BaseModel;
use App\Models\StaticPageBlock;
use App\Models\StaticPageContent;
use App\Models\StaticPageType;
use App\Services\ContentManagementServices\CmsLanguageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaticPageContentOrBlockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $response = [
            "id" => $this->id,
            "static_page_type_id" => $this->static_page_type_id,
            "show_in" => $this->show_in,
            "show_in_label" => BaseModel::SHOW_INS[$this->show_in],
            "institute_id" => $this->institute_id,
            "institute_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INSTITUTE_SERVICE][$this->institute_id]['title'] ?? "",
            "institute_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INSTITUTE_SERVICE][$this->institute_id]['title_en'] ?? "",
            "organization_id" => $this->organization_id,
            "organization_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::ORGANIZATION_SERVICE][$this->organization_id]['title'] ?? "",
            "organization_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::ORGANIZATION_SERVICE][$this->organization_id]['title_en'] ?? "",
            "industry_association_id" => $this->industry_association_id,
            "industry_association_title" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INDUSTRY_ASSOCIATION_TITLE][$this->industry_association_id]['title'] ?? "",
            "industry_association_title_en" => $request->get(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID)[BaseModel::INDUSTRY_ASSOCIATION_TITLE][$this->industry_association_id]['title_en'] ?? "",
        ];

        if($this->type == StaticPageType::TYPE_PAGE_BLOCK){
            $response['attachment_type'] = $this->attachment_type;
            $response['template_code'] = $this->template_code;
            $response["static_page_block_template"] = config("nise3.page_block_template." . $this->template_code);
            $response['is_button_available'] = $this->is_button_available;
            $response['link'] = $this->link;
            $response['is_attachment_available'] = $this->is_attachment_available;
            $response['image_path'] = $this->image_path;
            $response['video_url'] = $this->video_url;
            $response['video_id'] = $this->video_id;
            $response['image_alt_title_en'] = $this->image_alt_title_en;
            if ($request->offsetExists(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY) && $request->get(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY)) {
                $response['title'] = app(CmsLanguageService::class)->getLanguageValue($this, StaticPageBlock::LANGUAGE_ATTR_TITLE);
                $response['content'] = app(CmsLanguageService::class)->getLanguageValue($this, StaticPageBlock::LANGUAGE_ATTR_CONTENT);
                $response['button_text'] = app(CmsLanguageService::class)->getLanguageValue($this, StaticPageBlock::LANGUAGE_ATTR_BUTTON_TEXT);
                $response['image_alt_title'] = app(CmsLanguageService::class)->getLanguageValue($this, StaticPageBlock::LANGUAGE_ATTR_IMAGE_ALT_TITLE);
            } else {
                $response['title'] = $this->title;
                $response['content'] = $this->content;
                $response['button_text'] = $this->button_text;
                $response['image_alt_title'] = $this->image_alt_title;
                if (!$request->get(BaseModel::IS_COLLECTION_KEY)) {
                    $response[BaseModel::OTHER_LANGUAGE_FIELDS_KEY] = CmsLanguageService::otherLanguageResponse($this);
                }
            }
        } else if($this->type == StaticPageType::TYPE_STATIC_PAGE){
            $response['sub_title_en'] = $this->sub_title_en;
            if ($request->offsetExists(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY) && $request->get(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY)) {
                $response['title'] = app(CmsLanguageService::class)->getLanguageValue($this, StaticPageContent::LANGUAGE_ATTR_TITLE);
                $response['sub_title'] = app(CmsLanguageService::class)->getLanguageValue($this, StaticPageContent::LANGUAGE_ATTR_SUB_TITLE);
                $response['content'] = app(CmsLanguageService::class)->getLanguageValue($this, StaticPageContent::LANGUAGE_ATTR_CONTENTS);
            } else {
                $response['title'] = $this->title;
                $response['sub_title'] = $this->sub_title;
                $response['content'] = $this->content;
                if (!$request->get(BaseModel::IS_COLLECTION_KEY)) {
                    $response[BaseModel::OTHER_LANGUAGE_FIELDS_KEY] = CmsLanguageService::otherLanguageResponse($this);
                }
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
