<?php

namespace App\Http\Resources;

use App\Models\Faq;
use App\Services\Common\LanguageCodeService;
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
        $languageCode = strtolower($request->server('HTTP_ACCEPT_LANGUAGE'));

        /** @var Faq $this */

        $response = [
            "id" => $this->id,
            "show_in" => $this->show_in,
            "institute_id" => $this->institute_id,
            "industry_association_id" => $this->industry_association_id,
            "organization_id" => $this->organization_id,
            'question' => $this->question,
            'question_en' => $this->question_en,
            'answer' => $this->question_en,
            'answer_en' => $this->answer_en,
        ];

        if (!empty(Faq::FAQ_LANGUAGE_FILLABLE) && is_array(Faq::FAQ_LANGUAGE_FILLABLE) && $languageCode && in_array($languageCode, LanguageCodeService::getLanguageCode())) {
            $tableName = $this->getTable();
            $keyId = $this->id;

            foreach (Faq::FAQ_LANGUAGE_FILLABLE as $translatableKey) {
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
