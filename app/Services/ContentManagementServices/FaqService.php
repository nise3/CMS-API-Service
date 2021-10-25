<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

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
            'faqs.question_en',
            'faqs.answer',
            'faqs.answer_en',
            'faqs.row_status',
            'faqs.created_by',
            'faqs.updated_by',
            'faqs.created_at',
            'faqs.updated_at'
        ]);

        $faqBuilder->orderBy('faqs.id', $order);
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

        $response = [];
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
     * @return Faq
     */
    public function getOneFaq(int $id): Faq
    {
        /** @var Builder $faqBuilder */
        $faqBuilder = Faq::select([
            'faqs.id',
            'faqs.show_in',
            'faqs.institute_id',
            'faqs.industry_association_id',
            'faqs.organization_id',
            'faqs.question',
            'faqs.question_en',
            'faqs.answer',
            'faqs.answer_en',
            'faqs.row_status',
            'faqs.created_by',
            'faqs.updated_by',
            'faqs.created_at',
            'faqs.updated_at'
        ]);
        $faqBuilder->where('faqs.id', $id);

        /** @var Faq $faq */
        $faq=$faqBuilder->first();

        return $faq;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'order.in' => 'Order must be within ASC or DESC.[30000]',
            'row_status.in' => 'Row status must be within 1 or 0.[30000]'
        ];

        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }

        return Validator::make($request->all(), [
            'question' => 'nullable|max:191|min:2',
            'question_en' => 'nullable|max:191|min:2',
            'answer' => 'nullable|min:500|min:2',
            'answer_en' => 'nullable|min:500|min:2',
            'show_in' => 'numeric|gt:0',
            'institute_id' => 'numeric|gt:0',
            'industry_association_id' => 'numeric|gt:0',
            'organization_id' => 'numeric|gt:0',
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
