<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\StaticPageBlock;
use App\Services\Common\LanguageCodeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class StaticPageContentOrPageBlock
{
    /**
     * @param array $request
     * @return Collection|LengthAwarePaginator|array
     */
    public function getAllStaticPages(array $request): Collection|LengthAwarePaginator|array
    {
        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $instituteId = $request['institute_id'] ?? "";
        $organizationId = $request['organization_id'] ?? "";
        $industryAssociationId = $request['industry_association_id'] ?? "";
        $contentSlugOrId = $request['content_slug_or_id'] ?? "";
        $showIn = $request['show_in'] ?? "";
        $isRequestFromClientSide = !empty($request[BaseModel::IS_CLIENT_SITE_RESPONSE_KEY]);

        /** @var Builder $staticPageBuilder */
        $staticPageBuilder = StaticPageBlock::select([
            'static_pages_and_block.id',
            'static_pages_and_block.content_type',
            'static_pages_and_block.show_in',
            'static_pages_and_block.content_slug_or_id',
            'static_pages_and_block.institute_id',
            'static_pages_and_block.organization_id',
            'static_pages_and_block.industry_association_id',
            'static_pages_and_block.title',
            'static_pages_and_block.title_en',
            'static_pages_and_block.sub_title',
            'static_pages_and_block.sub_title_en',
            'static_pages_and_block.contents',
            'static_pages_and_block.contents_en',
            'static_pages_and_block.row_status',
            'static_pages_and_block.created_by',
            'static_pages_and_block.updated_by',
            'static_pages_and_block.created_at',
            'static_pages_and_block.updated_at'
        ]);
        $staticPageBuilder->orderBy('static_pages_and_block.id', $order);

        if ($isRequestFromClientSide) {
            $staticPageBuilder->active();
        }

        if (is_numeric($rowStatus)) {
            $staticPageBuilder->where('static_pages_and_block.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $staticPageBuilder->where('static_pages_and_block.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $staticPageBuilder->where('static_pages_and_block.title', 'like', '%' . $titleBn . '%');
        }

        if (is_numeric($instituteId)) {
            $staticPageBuilder->where('static_pages_and_block.institute_id', '=', $instituteId);
        }

        if (is_numeric($organizationId)) {
            $staticPageBuilder->where('static_pages_and_block.organization_id', '=', $organizationId);
        }

        if (is_numeric($industryAssociationId)) {
            $staticPageBuilder->where('static_pages_and_block.industry_association_id', '=', $industryAssociationId);
        }

        if (!empty($contentSlugOrId)) {
            $staticPageBuilder->where('static_pages_and_block.content_slug_or_id', $contentSlugOrId);
        }

        if (is_numeric($showIn)) {
            $staticPageBuilder->where('static_pages_and_block.show_in', '=', $showIn);
        }

        /** @var Collection $staticPages */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $staticPages = $staticPageBuilder->paginate($pageSize);
        } else {
            $staticPages = $staticPageBuilder->get();
        }

        return $staticPages;
    }

    /**
     * @param int $id
     * @return Builder|Model
     */
    public function getOneStaticPage(int $id): Builder|Model
    {
        /** @var Builder $staticPageBuilder */
        $staticPageBuilder = StaticPageBlock::select([
            'static_pages_and_block.id',
            'static_pages_and_block.content_type',
            'static_pages_and_block.show_in',
            'static_pages_and_block.content_slug_or_id',
            'static_pages_and_block.institute_id',
            'static_pages_and_block.organization_id',
            'static_pages_and_block.industry_association_id',
            'static_pages_and_block.title',
            'static_pages_and_block.title_en',
            'static_pages_and_block.sub_title',
            'static_pages_and_block.sub_title_en',
            'static_pages_and_block.contents',
            'static_pages_and_block.contents_en',
            'static_pages_and_block.row_status',
            'static_pages_and_block.created_by',
            'static_pages_and_block.updated_by',
            'static_pages_and_block.created_at',
            'static_pages_and_block.updated_at'
        ]);
        $staticPageBuilder->where('static_pages_and_block.id', $id);


        /** @var StaticPageBlock $staticPage */
        return $staticPageBuilder->firstOrFail();
    }

    /**
     * @param array $request
     * @param string $contentOrSlugId
     * @return Builder|Model
     */
    public function getPublicOneStaticPage(array $request, string $contentOrSlugId): Builder|Model
    {
        $instituteId = $request['institute_id'] ?? "";
        $organizationId = $request['organization_id'] ?? "";
        $industryAssociationId = $request['industry_association_id'] ?? "";
        $showIn = $request['show_in'] ?? "";

        /** @var Builder $staticPageBuilder */
        $staticPageBuilder = StaticPageBlock::select([
            'static_pages_and_block.id',
            'static_pages_and_block.content_type',
            'static_pages_and_block.show_in',
            'static_pages_and_block.content_slug_or_id',
            'static_pages_and_block.institute_id',
            'static_pages_and_block.organization_id',
            'static_pages_and_block.industry_association_id',
            'static_pages_and_block.title',
            'static_pages_and_block.title_en',
            'static_pages_and_block.sub_title',
            'static_pages_and_block.sub_title_en',
            'static_pages_and_block.contents',
            'static_pages_and_block.contents_en',
            'static_pages_and_block.row_status',
            'static_pages_and_block.created_by',
            'static_pages_and_block.updated_by',
            'static_pages_and_block.created_at',
            'static_pages_and_block.updated_at'
        ]);

        $staticPageBuilder->where('static_pages_and_block.content_slug_or_id', $contentOrSlugId);

        if (is_numeric($instituteId)) {
            $staticPageBuilder->where('static_pages_and_block.institute_id', '=', $instituteId);
        }
        if (is_numeric($organizationId)) {
            $staticPageBuilder->where('static_pages_and_block.organization_id', '=', $organizationId);
        }
        if (is_numeric($industryAssociationId)) {
            $staticPageBuilder->where('static_pages_and_block.industry_association_id', '=', $industryAssociationId);
        }
        if (is_numeric($showIn)) {
            $staticPageBuilder->where('static_pages_and_block.show_in', '=', $showIn);
        }

        /** @var StaticPageBlock $staticPage */
        return $staticPageBuilder->firstOrFail();
    }

    /**
     * @param array $data
     * @return StaticPageBlock
     */
    public function store(array $data): StaticPageBlock
    {
        if(!empty($data['content_slug_or_id'])){
            $data['content_slug_or_id'] = str_replace(' ', '_', $data['content_slug_or_id']);
        }
        $staticPage = new StaticPageBlock();
        $staticPage->fill($data);
        $staticPage->save();
        return $staticPage;
    }


    /**
     * @param StaticPageBlock $staticPage
     * @param array $data
     * @return StaticPageBlock
     */
    public function update(StaticPageBlock $staticPage, array $data): StaticPageBlock
    {
        if(!empty($data['content_slug_or_id'])){
            $data['content_slug_or_id'] = str_replace(' ', '_', $data['content_slug_or_id']);
        }
        $staticPage->fill($data);
        $staticPage->save();
        return $staticPage;
    }

    /**
     * @param StaticPageBlock $staticPage
     * @return bool
     */
    public function destroy(StaticPageBlock $staticPage): bool
    {
        return $staticPage->delete();
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
            'title' => [
                'required',
                'string',
                'max:500',
                'min:2'
            ],
            'sub_title' => [
                'nullable',
                'string'
            ],
            'contents' => [
                'nullable',
                'string'
            ],
        ];
        return Validator::make($request, $rules, $customMessage);
    }

    /**
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];
        $request->offsetSet('deleted_at', null);
        $rules = [
            'content_type' => [
                'required',
                'int',
                Rule::in(StaticPageBlock::CONTENT_TYPES)
            ],
            'show_in' => [
                'required',
                'integer',
                Rule::in(array_keys(BaseModel::SHOW_INS))
            ],
            'content_slug_or_id' => [
                'required',
                'string',
                'max:300'
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
            'title' => [
                'required',
                'string',
                'max:500',
                'min:2'
            ],
            'archived_at' => [
                'nullable',
                'date',
                'after:published_at'
            ],
            'sub_title' => [
                'nullable',
                'string'
            ],
            'contents_en' => [
                'nullable',
                'string'
            ],
            'contents' => [
                'nullable',
                'string'
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]
        ];

        /** Add validation for field "content_slug_or_id" */
        if($request->filled('show_in')){
            if($request->input('show_in') == BaseModel::SHOW_IN_NISE3 || $request->input('show_in') == BaseModel::SHOW_IN_YOUTH){
                $rules['content_slug_or_id'][] = 'unique_with:static_pages_and_block,show_in,deleted_at,' . $id;
            }
            if($request->input('show_in') == BaseModel::SHOW_IN_TSP){
                $rules['content_slug_or_id'][] = 'unique_with:static_pages_and_block,institute_id,deleted_at,' . $id;
            }
            if($request->input('show_in') == BaseModel::SHOW_IN_INDUSTRY){
                $rules['content_slug_or_id'][] = 'unique_with:static_pages_and_block,organization_id,deleted_at,' . $id;
            }
            if($request->input('show_in') == BaseModel::SHOW_IN_INDUSTRY_ASSOCIATION){
                $rules['content_slug_or_id'][] = 'unique_with:static_pages_and_block,industry_association_id,deleted_at,' . $id;
            }
        }

        $rules = array_merge($rules, BaseModel::OTHER_LANGUAGE_VALIDATION_RULES);
        return Validator::make($request->all(), $rules, $customMessage);

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
            'title_en' => 'nullable|max:200|min:2',
            'title' => 'nullable|max:500|min:2',
            'page' => 'nullable|integer|gt:0',
            'page_size' => 'nullable|integer|gt:0',
            'institute_id' => 'nullable|integer|gt:0',
            'organization_id' => 'nullable|integer|gt:0',
            'industry_association_id' => 'nullable|integer|gt:0',
            'content_slug_or_id' => 'nullable|string',
            'show_in' => 'nullable|integer|gt:0',
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
