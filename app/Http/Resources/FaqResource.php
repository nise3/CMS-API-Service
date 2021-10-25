<?php

namespace App\Http\Resources;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

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
        $languageCode = strtoupper($request->server('HTTP_ACCEPT_LANGUAGE'));

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

        if ($languageCode && !in_array($languageCode, config('nise3.default_language_code'))) {
            $tableName = $this->getTable();
            $keyId = $this->id;
            $question = getLanguageValue($tableName, $keyId, Faq::LANGUAGE_ATTR_QUESTION);
            $response = array_merge($response, $question);
            $answer = getLanguageValue($tableName, $keyId, Faq::LANGUAGE_ATTR_ANSWER);
            $response = array_merge($response, $answer);
        }

        $response['row_status']=$this->row_status;
        $response['created_by']=$this->create_by;
        $response['updated_by']=$this->updated_by;
        $response['created_at']=$this->created_at;
        $response['updated_at']=$this->updated_at;

        return $response;
    }
}
