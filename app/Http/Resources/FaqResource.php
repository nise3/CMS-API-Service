<?php

namespace App\Http\Resources;

use App\Models\Faq;
use App\Services\ContentManagementServices\CmsLanguageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Faq $this */
        return [
            "id" => $this->id,
            "show_in" => $this->show_in,
            "institute_id" => $this->institute_id,
            "industry_association_id" => $this->industry_association_id,
            "organization_id" => $this->organization_id,
            "question" => app(CmsLanguageService::class)->getLanguageValue($this, Faq::LANGUAGE_ATTR_QUESTION),
            "answer" => app(CmsLanguageService::class)->getLanguageValue($this, Faq::LANGUAGE_ATTR_ANSWER),
            "row_status" => $this->row_status,
            "created_by" => $this->created_by,
            "updated_by" => $this->updated_by,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];

    }
}
