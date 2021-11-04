<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\VisitorFeedbackSuggestion;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VisitorFeedbackSuggestionService
{
    public function getVisitorFeedbackSuggestionList(array $request): Collection|LengthAwarePaginator|array
    {
        $titleEn = $request['title_en'] ?? "";
        $title = $request['title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Builder $visitorFeedbackSuggestionBuilder */
        $visitorFeedbackSuggestionBuilder = VisitorFeedbackSuggestion::select([
            'visitor_feedbacks_suggestions.id',
            'visitor_feedbacks_suggestions.show_in',
            'visitor_feedbacks_suggestions.institute_id',
            'visitor_feedbacks_suggestions.organization_id',
            'visitor_feedbacks_suggestions.industry_association_id',
            'visitor_feedbacks_suggestions.mobile',
            'visitor_feedbacks_suggestions.email',
            'visitor_feedbacks_suggestions.name',
            'visitor_feedbacks_suggestions.name_en',
            'visitor_feedbacks_suggestions.address',
            'visitor_feedbacks_suggestions.address_en',
            'visitor_feedbacks_suggestions.comment_en',
            'visitor_feedbacks_suggestions.read_at',
            'visitor_feedbacks_suggestions.archived_at',
            'visitor_feedbacks_suggestions.archived_by',
            'visitor_feedbacks_suggestions.row_status',
            'visitor_feedbacks_suggestions.created_at',
            'visitor_feedbacks_suggestions.updated_at'
        ]);
        $visitorFeedbackSuggestionBuilder->orderBy('visitor_feedbacks_suggestions.id', $order);

        if (is_numeric($rowStatus)) {
            $visitorFeedbackSuggestionBuilder->where('visitor_feedbacks_suggestions.row_status', $rowStatus);
        }
        if (!empty($titleEn)) {
            $visitorFeedbackSuggestionBuilder->where('visitor_feedbacks_suggestions.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($title)) {
            $visitorFeedbackSuggestionBuilder->where('visitor_feedbacks_suggestions.title', 'like', '%' . $title . '%');
        }


        /** @var Collection $humanResources */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $visitorFeedbackSuggestion = $visitorFeedbackSuggestionBuilder->paginate($pageSize);
        } else {
            $visitorFeedbackSuggestion = $visitorFeedbackSuggestionBuilder->get();
        }
        return $visitorFeedbackSuggestion;

    }

    public function getOneVisitorFeedbackSuggestion(int $id): Model|Builder
    {
        /** @var Builder $visitorFeedbackSuggestionBuilder */
        $visitorFeedbackSuggestionBuilder = VisitorFeedbackSuggestion::select([
            'visitor_feedbacks_suggestions.id',
            'visitor_feedbacks_suggestions.show_in',
            'visitor_feedbacks_suggestions.institute_id',
            'visitor_feedbacks_suggestions.organization_id',
            'visitor_feedbacks_suggestions.industry_association_id',
            'visitor_feedbacks_suggestions.mobile',
            'visitor_feedbacks_suggestions.email',
            'visitor_feedbacks_suggestions.name',
            'visitor_feedbacks_suggestions.name_en',
            'visitor_feedbacks_suggestions.address',
            'visitor_feedbacks_suggestions.address_en',
            'visitor_feedbacks_suggestions.comment_en',
            'visitor_feedbacks_suggestions.read_at',
            'visitor_feedbacks_suggestions.archived_at',
            'visitor_feedbacks_suggestions.archived_by',
            'visitor_feedbacks_suggestions.row_status',
            'visitor_feedbacks_suggestions.created_at',
            'visitor_feedbacks_suggestions.updated_at'
        ]);

        $visitorFeedbackSuggestionBuilder->where('visitor_feedbacks_suggestions.id', $id);


        return $visitorFeedbackSuggestionBuilder->firstOrFail();
    }

    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'order.in' => 'Order must be within ASC or DESC.[30000]',
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];

        if ($request->filled('order')) {
            $request->offsetSet('order', strtoupper($request->get('order')));
        }

        return Validator::make($request->all(), [
            'name_en' => 'nullable|max:200|min:2',
            'name' => 'nullable|max:600|min:2',
            'page' => 'nullable|integer|gt:0',
            'page_size' => 'nullable|integer|gt:0',
            'order' => [
                'nullable',
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                'nullable',
                "integer",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }
}
