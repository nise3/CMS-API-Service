<?php

namespace App\Http\Resources;

use App\Models\BaseModel;
use App\Models\GalleryAlbum;
use App\Models\StaticPageBlock;
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
            "title_en" => $this->title_en,
            "content_en" => $this->content_en,
        ];

        if($this->static_page_type_id == StaticPageBlock::CONTENT_TYPE_BLOCK){
            $response['attachment_type'] = $this->attachment_type;
            $response['template_code'] = $this->template_code;
            $response['is_button_available'] = $this->is_button_available;
            $response['link'] = $this->link;
            $response['is_attachment_available'] = $this->is_attachment_available;
            $response['image_path'] = $this->image_path;
            $response['video_url'] = $this->video_url;
            $response['alt_image_title_en'] = $this->alt_image_title_en;
            if ($request->offsetExists(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY) && $request->get(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY)) {
                $response['title'] = app(CmsLanguageService::class)->getLanguageValue($this, GalleryAlbum::LANGUAGE_ATTR_TITLE);
                $response['content'] = app(CmsLanguageService::class)->getLanguageValue($this, GalleryAlbum::LANGUAGE_ATTR_IMAGE_ALT_TITLE);
                $response['button_text'] = app(CmsLanguageService::class)->getLanguageValue($this, GalleryAlbum::LANGUAGE_ATTR_IMAGE_ALT_TITLE);
                $response['alt_image_title'] = app(CmsLanguageService::class)->getLanguageValue($this, GalleryAlbum::LANGUAGE_ATTR_IMAGE_ALT_TITLE);
            } else {
                $response['title'] = $this->title;
                $response['content'] = $this->content;
                $response['button_text'] = $this->button_text;
                $response['alt_image_title'] = $this->alt_image_title;
                if (!$request->get(BaseModel::IS_COLLECTION_KEY)) {
                    $response[BaseModel::OTHER_LANGUAGE_FIELDS_KEY] = CmsLanguageService::otherLanguageResponse($this);
                }
            }
        } else if($this->static_page_type_id == StaticPageBlock::CONTENT_TYPE_STATIC_PAGE){
            $response['sub_title_en'] = $this->sub_title_en;
            if ($request->offsetExists(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY) && $request->get(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY)) {
                $response['title'] = app(CmsLanguageService::class)->getLanguageValue($this, GalleryAlbum::LANGUAGE_ATTR_TITLE);
                $response['sub_title'] = app(CmsLanguageService::class)->getLanguageValue($this, GalleryAlbum::LANGUAGE_ATTR_TITLE);
                $response['content'] = app(CmsLanguageService::class)->getLanguageValue($this, GalleryAlbum::LANGUAGE_ATTR_TITLE);
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
