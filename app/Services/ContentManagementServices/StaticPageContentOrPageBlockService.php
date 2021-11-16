<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\StaticPageBlock;
use App\Models\StaticPageContent;
use App\Models\StaticPageType;
use App\Services\Common\LanguageCodeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class StaticPageContentOrPageBlockService
{
    /**
     * @param array $request
     * @param string $page_code
     * @return Builder|Model
     */
    public function getStaticPageOrBlock(array $request, string $page_code): Model|Builder
    {
        $showIn = $request['show_in'] ?? "";
        $type = $request['type'] ?? "";

        /** @var Builder $staticPageBuilder */
        if ($type == StaticPageType::TYPE_PAGE_BLOCK) {
            $staticPageBuilder = StaticPageBlock::select([
                'static_page_blocks.id',
                'static_page_blocks.show_in',
                'static_page_blocks.static_page_type_id',
                'static_page_blocks.institute_id',
                'static_page_blocks.organization_id',
                'static_page_blocks.industry_association_id',
                'static_page_blocks.title',
                'static_page_blocks.title_en',
                'static_page_blocks.content',
                'static_page_blocks.content_en',
                'static_page_blocks.attachment_type',
                'static_page_blocks.template_code',
                'static_page_blocks.is_button_available',
                'static_page_blocks.button_text',
                'static_page_blocks.link',
                'static_page_blocks.is_attachment_available',
                'static_page_blocks.image_path',
                'static_page_blocks.embedded_url',
                'static_page_blocks.embedded_id',
                'static_page_blocks.alt_image_title_en',
                'static_page_blocks.alt_image_title',
                'static_page_blocks.row_status',
                'static_page_blocks.created_by',
                'static_page_blocks.updated_by',
                'static_page_blocks.created_at',
                'static_page_blocks.updated_at'
            ]);
            $staticPageBuilder->join('static_page_types', function ($join) {
                $join->on('static_page_types.type', '=', 'static_page_contents.static_page_type_id',);
            });
            if (is_numeric($showIn)) {
                $staticPageBuilder->where('static_page_blocks.show_in', '=', $showIn);
            }
            if (!empty($type)) {
                $staticPageBuilder->where('static_page_blocks.static_page_type_id', '=', $type);
            }
            $staticPageBuilder->where('static_page_blocks.code', $page_code);

        } elseif ($type == StaticPageType::TYPE_STATIC_PAGE) {
            $staticPageBuilder = StaticPageContent::select([
                'static_page_contents.id',
                'static_page_contents.show_in',
                'static_page_contents.static_page_type_id',
                'static_page_contents.institute_id',
                'static_page_contents.organization_id',
                'static_page_contents.industry_association_id',
                'static_page_contents.title',
                'static_page_contents.title_en',
                'static_page_contents.sub_title',
                'static_page_contents.sub_title_en',
                'static_page_contents.content',
                'static_page_contents.content_en',
                'static_page_contents.row_status',
                'static_page_contents.created_by',
                'static_page_contents.updated_by',
                'static_page_contents.created_at',
                'static_page_contents.updated_at'
            ]);
            $staticPageBuilder->join('static_page_types', function ($join) {
                $join->on('static_page_types.type', '=', 'static_page_contents.static_page_type_id',);
            });
            if (is_numeric($showIn)) {
                $staticPageBuilder->where('static_page_types.show_in', '=', $showIn);
            }
            if (!empty($type)) {
                $staticPageBuilder->where('static_page_types.static_page_type_id', '=', $type);
            }
            $staticPageBuilder->where('static_page_blocks.code', $page_code);
        }
        return $staticPageBuilder->firstOrFail();
    }


    /**
     * @param array $data
     * @return StaticPageBlock
     */
    public function storeOrUpdate(array $data): StaticPageBlock
    {
        if (!empty($data['content_slug_or_id'])) {
            $data['content_slug_or_id'] = str_replace(' ', '_', $data['content_slug_or_id']);
        }
        $staticPage = new StaticPageBlock();
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
        $request->offsetSet('deleted_at', null);
        $rules = [
            'static_page_type_id' => [
                'required',
                'int',
                Rule::in(StaticPageType::TYPES)
            ],
            'show_in' => [
                'required',
                'integer',
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
        if ($request->filled('show_in')) {
            if ($request->input('show_in') == BaseModel::SHOW_IN_NISE3 || $request->input('show_in') == BaseModel::SHOW_IN_YOUTH) {
                $rules['content_slug_or_id'][] = 'unique_with:static_page_blocks,show_in,deleted_at,' . $id;
            }
            if ($request->input('show_in') == BaseModel::SHOW_IN_TSP) {
                $rules['content_slug_or_id'][] = 'unique_with:static_page_blocks,institute_id,deleted_at,' . $id;
            }
            if ($request->input('show_in') == BaseModel::SHOW_IN_INDUSTRY) {
                $rules['content_slug_or_id'][] = 'unique_with:static_page_blocks,organization_id,deleted_at,' . $id;
            }
            if ($request->input('show_in') == BaseModel::SHOW_IN_INDUSTRY_ASSOCIATION) {
                $rules['content_slug_or_id'][] = 'unique_with:static_page_blocks,industry_association_id,deleted_at,' . $id;
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
        return Validator::make($request->all(), [
            'type' => [
                'nullable',
                'integer',
                Rule::in(StaticPageType::TYPES)
            ],
            'show_in' => 'nullable|integer|gt:0',
        ]);
    }
}
