<?php

namespace App\Http\Resources;

use App\Models\BaseModel;
use App\Models\Faq;
use App\Models\Slider;
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
        $response = [
            "id" => $this->id,
            "show_in" => $this->show_in,
            "show_in_label" => BaseModel::SHOW_INS[$this->show_in],
            "institute_id" => $this->institute_id,
            "industry_association_id" => $this->industry_association_id,
            "organization_id" => $this->organization_id,
        ];
        if ($request->offsetExists(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY) && $request->get(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY)) {
            $response['question'] = app(CmsLanguageService::class)->getLanguageValue($this, Slider::SLIDER_LANGUAGE_ATTR_TITLE );
            $response['answer'] = app(CmsLanguageService::class)->getLanguageValue($this, Faq::LANGUAGE_ATTR_ANSWER);
        } else {
            $response['institute_title'] = "";
            $response['institute_title_en'] = "";
            $response['industry_association_title'] = "";
            $response['industry_association_title_en'] = "";
            $response['organization_title'] = "";
            $response['organization_title_en'] = "";
            $response['question'] = $this->question;
            $response['answer'] = $this->answer;
            if($request->offsetExists(BaseModel::IS_NOT_COLLECTION_KEY) && $request->get(BaseModel::IS_NOT_COLLECTION_KEY)){
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
