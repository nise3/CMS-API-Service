<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\NoticeOrNews;
use App\Services\Common\LanguageCodeService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


/**
 *
 */
class NoticeOrNewsService
{

    /**
     * @param array $request
     * @param null $startTime
     * @return Collection|LengthAwarePaginator|array
     */
    public function getNoticeOrNewsServiceList(array $request, $startTime = null): Collection|LengthAwarePaginator|array
    {
        $searchText = $request['search_text'] ?? "";
        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $instituteId = $request['institute_id'] ?? "";
        $organizationId = $request['organization_id'] ?? "";
        $industryAssociationId = $request['industry_association_id'] ?? "";
        $showIn = $request['show_in'] ?? "";
        $isRequestFromClientSide = !empty($request[BaseModel::IS_CLIENT_SITE_RESPONSE_KEY]);

        /** @var Builder $noticeOrNewsBuilder */
        $noticeOrNewsBuilder = NoticeOrNews::select([
            'notice_or_news.id',
            'notice_or_news.type',
            'notice_or_news.show_in',
            'notice_or_news.published_at',
            'notice_or_news.archived_at',
            'notice_or_news.title_en',
            'notice_or_news.title',
            'notice_or_news.institute_id',
            'notice_or_news.organization_id',
            'notice_or_news.industry_association_id',
            'notice_or_news.details',
            'notice_or_news.details_en',
            'notice_or_news.main_image_path',
            'notice_or_news.grid_image_path',
            'notice_or_news.thumb_image_path',
            'notice_or_news.image_alt_title_en',
            'notice_or_news.image_alt_title',
            'notice_or_news.file_path',
            'notice_or_news.file_alt_title_en',
            'notice_or_news.file_alt_title',
            'notice_or_news.row_status',
            'notice_or_news.created_by',
            'notice_or_news.updated_by',
            'notice_or_news.created_at',
            'notice_or_news.created_at',
        ]);
        $noticeOrNewsBuilder->orderBy('notice_or_news.id', $order);

        if (is_numeric($rowStatus)) {
            $noticeOrNewsBuilder->where('notice_or_news.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $noticeOrNewsBuilder->where('notice_or_news.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $noticeOrNewsBuilder->where('notice_or_news.title', 'like', '%' . $titleBn . '%');
        }

        if ($isRequestFromClientSide) { // If request fro client side
            $noticeOrNewsBuilder->whereDate('notice_or_news.published_at', '<=', $startTime);
            $noticeOrNewsBuilder->where(function ($builder) use ($startTime) {
                $builder->whereNull('notice_or_news.archived_at');
                $builder->orWhereDate('notice_or_news.archived_at', '>=', $startTime);
            });

            $noticeOrNewsBuilder->active();
        }

        if (is_numeric($instituteId)) {
            $noticeOrNewsBuilder->where('notice_or_news.institute_id', '=', $instituteId);
        }

        if (is_numeric($organizationId)) {
            $noticeOrNewsBuilder->where('notice_or_news.organization_id', '=', $organizationId);
        }

        if (is_numeric($industryAssociationId)) {
            $noticeOrNewsBuilder->where('notice_or_news.industry_association_id', '=', $industryAssociationId);
        }

        if (is_numeric($showIn)) {
            $noticeOrNewsBuilder->where('notice_or_news.show_in', '=', $showIn);
        }

        if(!empty($searchText)){
            $noticeOrNewsBuilder->where(function($builder) use ($searchText){
                $builder->orWhere('notice_or_news.title', 'like', '%' . $searchText . '%');
                $builder->orWhere('notice_or_news.title_en', 'like', '%' . $searchText . '%');
                $builder->orWhere('notice_or_news.details', 'like', '%' . $searchText . '%');
                $builder->orWhere('notice_or_news.details_en', 'like', '%' . $searchText . '%');
            });
        }

        /** @var Collection $noticeOrNews */
        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $noticeOrNews = $noticeOrNewsBuilder->paginate($pageSize);
        } else {
            $noticeOrNews = $noticeOrNewsBuilder->get();
        }
        return $noticeOrNews;

    }

    /**
     * @param int $id
     * @return Builder|Model
     */
    public function getOneNoticeOrNewsService(int $id): Builder|Model
    {
        /** @var Builder $noticeOrNewsBuilder */
        $noticeOrNewsBuilder = NoticeOrNews::select([
            'notice_or_news.id',
            'notice_or_news.type',
            'notice_or_news.show_in',
            'notice_or_news.published_at',
            'notice_or_news.archived_at',
            'notice_or_news.title_en',
            'notice_or_news.title',
            'notice_or_news.institute_id',
            'notice_or_news.organization_id',
            'notice_or_news.industry_association_id',
            'notice_or_news.details',
            'notice_or_news.details_en',
            'notice_or_news.main_image_path',
            'notice_or_news.grid_image_path',
            'notice_or_news.thumb_image_path',
            'notice_or_news.image_alt_title_en',
            'notice_or_news.image_alt_title',
            'notice_or_news.file_path',
            'notice_or_news.file_alt_title_en',
            'notice_or_news.file_alt_title',
            'notice_or_news.row_status',
            'notice_or_news.created_by',
            'notice_or_news.updated_by',
            'notice_or_news.created_at',
            'notice_or_news.created_at',
        ]);
        $noticeOrNewsBuilder->where('notice_or_news.id', $id);

        /** @var Collection $noticeOrNews */
        return $noticeOrNewsBuilder->firstOrFail();
    }


    /**
     * @param array $data
     * @return NoticeOrNews
     */
    public function store(array $data): NoticeOrNews
    {
        $noticeOrNews = new NoticeOrNews();
        $noticeOrNews->fill($data);
        $noticeOrNews->save();
        return $noticeOrNews;
    }


    /**
     * @param NoticeOrNews $noticeOrNews
     * @param array $data
     * @return NoticeOrNews
     */
    public function update(NoticeOrNews $noticeOrNews, array $data): NoticeOrNews
    {

        $noticeOrNews->fill($data);
        $noticeOrNews->save();
        return $noticeOrNews;
    }


    /**
     * @param NoticeOrNews $noticeOrNews
     * @return bool
     */
    public function destroy(NoticeOrNews $noticeOrNews): bool
    {
        return $noticeOrNews->delete();
    }

    /**
     * @param array $data
     * @param NoticeOrNews $noticeOrNews
     * @return NoticeOrNews
     * @throws \Throwable
     */
    public function publishOrArchiveNoticeOrNews(array $data, NoticeOrNews $noticeOrNews): NoticeOrNews
    {
        if ($data['status'] == BaseModel::STATUS_PUBLISH) {
            $noticeOrNews->published_at = Carbon::now()->format('Y-m-d H:i:s');
            $noticeOrNews->archived_at = null;
        }
        if ($data['status'] == BaseModel::STATUS_ARCHIVE) {
            $noticeOrNews->archived_at = Carbon::now()->format('Y-m-d H:i:s');
        }
        $noticeOrNews->saveOrFail();

        return $noticeOrNews;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function publishOrArchiveValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'status' => [
                'integer',
                Rule::in(BaseModel::PUBLISH_OR_ARCHIVE_STATUSES)
            ]

        ];
        return Validator::make($request->all(), $rules);
    }

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
            'title' => [
                'required',
                'string',
                'max:500',
                'min:2'
            ],
            'details' => [
                'nullable',
                'string'
            ],
            'image_alt_title' => [
                'nullable',
                'string'
            ],
            'file_alt_title' => [
                'nullable',
                'string'
            ],

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
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];

        if ($request->filled('order')) {
            $request->offsetSet('order', strtoupper($request->get('order')));
        }

        return Validator::make($request->all(), [
            'title_en' => 'nullable|max:250|min:2',
            'title' => 'nullable|max:500|min:2',
            'page' => 'nullable|integer|gt:0',
            'page_size' => 'nullable|integer|gt:0',
            'institute_id' => 'nullable|integer|gt:0',
            'organization_id' => 'nullable|integer|gt:0',
            'industry_association_id' => 'nullable|integer|gt:0',
            'show_in' => 'nullable|integer|gt:0',
            'order' => [
                'nullable',
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'search_text' => [
                'nullable',
                'string'
            ],
            'row_status' => [
                'nullable',
                "integer",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }

    /**
     * @param $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator($request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];
        $rules = [
            'type' => [
                'required',
                Rule::in(NoticeOrNews::TYPES)
            ],
            'show_in' => [
                "required",
                "integer",
                Rule::in(array_keys(BaseModel::SHOW_INS))
            ],
            'title' => [
                'required',
                'string',
                'max:500',
                'min:2'
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
            'published_at' => [
                'nullable',
                'date',
            ],
            'archived_at' => [
                'nullable',
                'date',
                'after:published_at'
            ],
            'details' => [
                'nullable',
                'string'
            ],
            'main_image_path' => [
                'required',
                'string',
            ],
            'grid_image_path' => [
                'nullable',
                'string',
            ],
            'thumb_image_path' => [
                'nullable',
                'string',
            ],
            'image_alt_title' => [
                'nullable',
                'string'
            ],
            'file_path' => [
                'nullable',
                'string'
            ],
            'file_alt_title' => [
                'nullable',
                'string'
            ],

            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]

        ];
        $rules = array_merge($rules, BaseModel::OTHER_LANGUAGE_VALIDATION_RULES);

        return Validator::make($request->all(), $rules, $customMessage);
    }

}
