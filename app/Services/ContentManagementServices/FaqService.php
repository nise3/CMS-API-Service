<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\Faq;
use App\Services\Common\LanguageCodeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class FaqService
{
    /**
     * @param array $request
     * @return Collection|LengthAwarePaginator|array
     */
    public function getFaqList(array $request): Collection|LengthAwarePaginator|array
    {
        $showIn = $request['show_in'] ?? "";
        $instituteId = $request['institute_id'] ?? "";
        $industryAssociationId = $request['industry_association_id'] ?? "";
        $organizationId = $request['organization_id'] ?? "";
        $question = $request['question'] ?? "";
        $questionEn = $request['question_en'] ?? "";
        $answer = $request['answer'] ?? "";
        $answerEn = $request['answer_en'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $isRequestFromClientSide = !empty($request[BaseModel::IS_CLIENT_SITE_RESPONSE_KEY]);

        /** Optional Parameters for Pagination */
        $page = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";

        /** @var Builder $faqBuilder */
        $faqBuilder = Faq::select([
            'faqs.id',
            'faqs.show_in',
            'faqs.institute_id',
            'faqs.industry_association_id',
            'faqs.organization_id',
            'faqs.question',
            'faqs.answer',
            'faqs.row_status',
            'faqs.created_by',
            'faqs.updated_by',
            'faqs.created_at',
            'faqs.updated_at'

        ]);

        /** If private API */
        if (!$isRequestFromClientSide) {
            $faqBuilder->acl();
        }

        $faqBuilder->orderBy('faqs.id', $order);

        /** If public API */
        if($isRequestFromClientSide){
            $faqBuilder->active();
        }

        if (is_numeric($showIn)) {
            $faqBuilder->where('faqs.show_in', $showIn);
        }
        if (is_numeric($instituteId)) {
            $faqBuilder->where('faqs.institute_id', $instituteId);
        }
        if (is_numeric($industryAssociationId)) {
            $faqBuilder->where('faqs.industry_association_id', $industryAssociationId);
        }
        if (is_numeric($organizationId)) {
            $faqBuilder->where('faqs.organization_id', $organizationId);
        }
        if (is_numeric($rowStatus)) {
            $faqBuilder->where('faqs.row_status', $rowStatus);
        }
        if (!empty($question)) {
            $faqBuilder->where('faqs.question', 'like', '%' . $question . '%');
        }
        if (!empty($questionEn)) {
            $faqBuilder->where('faqs.question_en', 'like', '%' . $questionEn . '%');
        }
        if (!empty($answer)) {
            $faqBuilder->where('faqs.question', 'like', '%' . $answer . '%');
        }
        if (!empty($answerEn)) {
            $faqBuilder->where('faqs.question_en', 'like', '%' . $answerEn . '%');
        }

        /** @var Collection $response */
        if (is_numeric($page) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $response = $faqBuilder->paginate($pageSize);
        } else {
            $response = $faqBuilder->get();
        }
        return $response;
    }

    /**
     * @param int $id
     * @return Builder|Model|null
     */
    public function getOneFaq(int $id): Builder|Model|null
    {
        /** @var Builder $faqBuilder */
        $faqBuilder = Faq::select([
            'faqs.id',
            'faqs.show_in',
            'faqs.institute_id',
            'faqs.industry_association_id',
            'faqs.organization_id',
            'faqs.question',
            'faqs.answer',
            'faqs.row_status',
            'faqs.created_by',
            'faqs.updated_by',
            'faqs.created_at',
            'faqs.updated_at'
        ]);
        $faqBuilder->where('faqs.id', $id);

        /** @var Faq $faq */
        return $faqBuilder->firstOrFail();
    }

    /**
     * @param array $data
     * @return Faq
     */
    public function store(array $data): Faq
    {
        $faq = app(Faq::class);
        $faq->fill($data);
        $faq->save();
        return $faq;
    }

    /**
     * @param Faq $faq
     * @param array $data
     * @return Faq
     */
    public function update(Faq $faq, array $data): Faq
    {
        $faq->fill($data);
        $faq->save();
        return $faq;
    }

    /**
     * @param Faq $faq
     * @return bool
     */
    public function destroy(Faq $faq): bool
    {
        return $faq->delete();
    }


    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => 'Row status must be within 1 or 0.[30000]',
            'show_in.in' => 'Row status must be within (1=>Nise3, 2=>TSP, 3=>Industry, 4=>Industry Association).[30000]',
            'other_language_fields.*.regex' => "The language key must be lowercase.[49000]"
        ];
        $rules = [
            'show_in' => [
                "required",
                "integer",
                "gt:0",
                Rule::in(array_keys(BaseModel::SHOW_INS))
            ],
            'institute_id' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('show_in') == BaseModel::SHOW_IN_TSP;
                }),
                "nullable",
                "integer",
                "gt:0",
            ],
            'industry_association_id' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('show_in') == BaseModel::SHOW_IN_INDUSTRY_ASSOCIATION;
                }),
                "nullable",
                "integer",
                "gt:0",
            ],
            'organization_id' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('show_in') == BaseModel::SHOW_IN_INDUSTRY;
                }),
                "nullable",
                "integer",
                "gt:0",
            ],
            'question' => 'required|max:1800|min:2',
            'answer' => 'required|min:2',
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                'nullable',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]
        ];

        /** other_language_fields added here */
        $rules = array_merge($rules, BaseModel::OTHER_LANGUAGE_VALIDATION_RULES);

        return Validator::make($request->all(), $rules, $customMessage);
    }

    /**
     * @param array $request
     * @param string $languageCode
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function languageFieldValidator(array $request, string $languageCode): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'required' => 'The :attribute_' . strtolower($languageCode) . ' in other language fields is required.[50000]',
            'max' => 'The :attribute_' . strtolower($languageCode) . ' in other language fields must not be greater than :max characters.[39003]',
            'min' => 'The :attribute_' . strtolower($languageCode) . ' in other language fields must be at least :min characters.[42003]',
            'language_code.in' => "The language with code " . $languageCode . " is not allowed",
            'language_code.regex' => "The language  code " . $languageCode . " must be lowercase"
        ];
        $request['language_code'] = $languageCode;
        $rules = [
            "language_code" => [
                "required",
                "regex:/[a-z]/",
                Rule::in(LanguageCodeService::getLanguageCode())
            ],
            'question' => [
                "required",
                "string",
                "max:1800",
                "min:2"
            ],
            'answer' => [
                "required",
                "nullable",
                "string",
                "min:2"
            ]
        ];
        return Validator::make($request, $rules, $customMessage);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'order.in' => 'Order must be within ASC or DESC.[30000]',
            'row_status.in' => 'Row status must be within 1 or 0.[30000]',
            'show_in.in' => 'Row status must be within (1=>Nise3, 2=>TSP, 3=>Industry, 4=>Industry Association).[30000]',

        ];

        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }

        return Validator::make($request->all(), [
            'question' => 'nullable|max:191|min:2',
            'question_en' => 'nullable|max:191|min:2',
            'answer' => 'nullable|max:500|min:2',
            'answer_en' => 'nullable|min:500|min:2',
            'show_in' => 'nullable|int|gt:0',
            'institute_id' => 'nullable|int|gt:0',
            'industry_association_id' => 'nullable|int|gt:0',
            'organization_id' => 'nullable|int|gt:0',
            'page_size' => 'numeric|gt:0',
            'page' => 'numeric|gt:0',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "numeric",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }
}
