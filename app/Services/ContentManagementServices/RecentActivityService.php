<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\RecentActivity;
use App\Services\Common\LanguageCodeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RecentActivityService
{

    /**
     * @param array $request
     * @return Collection|LengthAwarePaginator|array
     */
    public function getRecentActivityList(array $request): Collection|LengthAwarePaginator|array
    {
        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";


        /** @var  Builder $recentActivityBuilder */
        $recentActivityBuilder = RecentActivity::select([
            'recent_activities.id',
            'recent_activities.show_in',
            'recent_activities.activity_date',
            'recent_activities.published_at',
            'recent_activities.archived_at',
            'recent_activities.institute_id',
            'recent_activities.organization_id',
            'recent_activities.industry_association_id',
            'recent_activities.title_en',
            'recent_activities.title',
            'recent_activities.content_type',
            'recent_activities.content_path',
            'recent_activities.content_properties',
            'recent_activities.collage_image_path',
            'recent_activities.collage_position',
            'recent_activities.thumb_image_path',
            'recent_activities.grid_image_path',
            'recent_activities.image_alt_title_en',
            'recent_activities.image_alt_title',
            'recent_activities.description_en',
            'recent_activities.description',
            'recent_activities.created_by',
            'recent_activities.updated_by',
            'recent_activities.created_at',
            'recent_activities.updated_at',
        ]);
        $recentActivityBuilder->orderBy('recent_activities.id', $order);

        if (is_numeric($rowStatus)) {
            $recentActivityBuilder->where('recent_activities.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $recentActivityBuilder->where('recent_activities.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $recentActivityBuilder->where('recent_activities.title', 'like', '%' . $titleBn . '%');
        }


        /** @var Collection $recentActivity */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $recentActivity = $recentActivityBuilder->paginate($pageSize);
        } else {
            $recentActivity = $recentActivityBuilder->get();
        }
        return $recentActivity;
    }

    /**
     * @param int $id
     * @return Model|Builder
     */
    public function getOneRecentActivity(int $id): Builder|Model
    {
        /** @var  Builder $recentActivityBuilder */
        $recentActivityBuilder = RecentActivity::select([
            'recent_activities.id',
            'recent_activities.show_in',
            'recent_activities.activity_date',
            'recent_activities.published_at',
            'recent_activities.archived_at',
            'recent_activities.institute_id',
            'recent_activities.organization_id',
            'recent_activities.industry_association_id',
            'recent_activities.title_en',
            'recent_activities.title',
            'recent_activities.content_type',
            'recent_activities.content_path',
            'recent_activities.content_properties',
            'recent_activities.collage_image_path',
            'recent_activities.collage_position',
            'recent_activities.thumb_image_path',
            'recent_activities.grid_image_path',
            'recent_activities.image_alt_title_en',
            'recent_activities.image_alt_title',
            'recent_activities.description_en',
            'recent_activities.description',
            'recent_activities.created_by',
            'recent_activities.updated_by',
            'recent_activities.created_at',
            'recent_activities.updated_at',
        ]);
        $recentActivityBuilder->where('recent_activities.id', $id);

        return $recentActivityBuilder->firstOrFail();

    }

    /**
     * @param array $data
     * @return RecentActivity
     */
    public function store(array $data): RecentActivity
    {
        $recentActivity = new RecentActivity();
        $recentActivity->fill($data);
        $recentActivity->save();
        return $recentActivity;
    }


    /**
     * @param RecentActivity $recentActivity
     * @param array $data
     * @return RecentActivity
     */
    public function update(RecentActivity $recentActivity, array $data): RecentActivity
    {

        $recentActivity->fill($data);
        $recentActivity->save();
        return $recentActivity;
    }


    /**
     * @param RecentActivity $recentActivity
     * @return bool
     */
    public function destroy(RecentActivity $recentActivity): bool
    {
        return $recentActivity->delete();
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
            'content_title' => [
                "required",
                "string",
                "max:600",
                "min:2"
            ],
            'content_description' => [
                "nullable",
                "string"
            ],
            'alt_title' => [
                "nullable",
                "string",
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
            'order.in' => [
                'code' => 30000,
                "message" => 'Order must be within ASC or DESC',
            ],
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];
        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }
        $rules = [
            "title_en" => "nullable|string",
            "title" => "nullable|string",
            'page' => 'nullable|integer|gt:0',
            'page_size' => 'nullable|integer|gt:0',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "integer",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ];
        return Validator::make($request->all(), $rules, $customMessage);
    }

    /**
     * @param $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator($request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $requestData = $request->all();
        $customMessage = [
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];
        $rules = [
            'show_in' => [
                'nullable',
                'integer',
                Rule::in(BaseModel::SHOW_INS)
            ],
            'activity_date' => [
                'nullable',
                'date'
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
            'title_en' => [
                'nullable',
                'string',
                'max:300',
                'min:2'
            ],
            'title' => [
                'required',
                'string',
                'max:1000',
                'min:2'
            ],
            'content_type' => [
                'required',
                Rule::in(RecentActivity::CONTENT_TYPES)
            ],
            'content_path' => [
                'required_if:Content_type,' . RecentActivity::CONTENT_TYPE_IMAGE,
                'nullable',
                'string',
                'max:800'
            ],
            'content_properties' => [
                'nullable',
                'string',
                'max:300'
            ],

            'collage_image_path' => [
                'nullable',
                'string',
                'max:600'
            ],
            'collage_position' => [
                'nullable',
                'string',
                'max:600'
            ],
            'thumb_image_path' => [
                'nullable',
                'string',
                'max:600'
            ],
            'grid_image_path' => [
                'nullable',
                'string',
                'max:500',
                'min:2'
            ],
            'image_alt_title' => [
                'nullable',
                'string',
                'max:500',
                'min:2'
            ],
            'description_en' => [
                'nullable',
                'string'
            ],
            'description' => [
                'nullable',
                'string'
            ],

            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]


        ];
        if ($requestData['content_type'] == RecentActivity::CONTENT_TYPE_YOUTUBE_VIDEO) {
            $rules['embedded_id'] = [
                'required',
                'max:300'
            ];
        }

        if (($requestData['content_type'] == RecentActivity::CONTENT_TYPE_FACEBOOK_VIDEO) or $requestData['content_type'] == RecentActivity::CONTENT_TYPE_YOUTUBE_VIDEO) {
            $rules['embedded_url'] = [
                'required',
                'string',
                'max:800'
            ];
        }

        return Validator::make($request->all(), $rules, $customMessage);
    }

}
