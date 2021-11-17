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
    public function getStaticPageOrBlock(array $request, string $page_code): Model|Builder|null
    {
        $showIn = $request['show_in'] ?? "";
        $instituteId = $request['institute_id'] ?? "";
        $organizationId = $request['organization_id'] ?? "";
        $industryAssociationId = $request['industry_association_id'] ?? "";

        /** @var StaticPageType|Builder $pageType */
        $pageType = StaticPageType::select(['type'])->where('page_code', $page_code)->firstOrFail();
        $type = $pageType['type'];
        $response = null;

        /** @var Builder $staticPageBuilder */
        if ($type == StaticPageType::TYPE_PAGE_BLOCK) {
            $staticPageBuilder = StaticPageBlock::select([
                'static_page_types.type',
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
                'static_page_blocks.video_url',
                'static_page_blocks.video_id',
                'static_page_blocks.image_alt_title_en',
                'static_page_blocks.image_alt_title',
                'static_page_blocks.row_status',
                'static_page_blocks.created_by',
                'static_page_blocks.updated_by',
                'static_page_blocks.created_at',
                'static_page_blocks.updated_at'
            ]);
            $staticPageBuilder->join('static_page_types', function ($join) {
                $join->on('static_page_types.id', '=', 'static_page_blocks.static_page_type_id',);
            });
            $staticPageBuilder->where('static_page_types.page_code', $page_code);

            if (is_numeric($showIn)) {
                $staticPageBuilder->where('static_page_blocks.show_in', '=', $showIn);
            }
            if (is_numeric($instituteId)) {
                $staticPageBuilder->where('static_page_blocks.institute_id', '=', $instituteId);
            }
            if (is_numeric($organizationId)) {
                $staticPageBuilder->where('static_page_blocks.organization_id', '=', $organizationId);
            }
            if (is_numeric($industryAssociationId)) {
                $staticPageBuilder->where('static_page_blocks.industry_association_id', '=', $industryAssociationId);
            }
            $response = $staticPageBuilder->first();

        } elseif ($type == StaticPageType::TYPE_STATIC_PAGE) {
            $staticPageBuilder = StaticPageContent::select([
                'static_page_types.type',
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
                $join->on('static_page_types.id', '=', 'static_page_contents.static_page_type_id',);
            });
            $staticPageBuilder->where('static_page_types.page_code', $page_code);

            if (is_numeric($showIn)) {
                $staticPageBuilder->where('static_page_contents.show_in', '=', $showIn);
            }
            if (is_numeric($instituteId)) {
                $staticPageBuilder->where('static_page_contents.institute_id', '=', $instituteId);
            }
            if (is_numeric($organizationId)) {
                $staticPageBuilder->where('static_page_contents.organization_id', '=', $organizationId);
            }
            if (is_numeric($industryAssociationId)) {
                $staticPageBuilder->where('static_page_contents.industry_association_id', '=', $industryAssociationId);
            }
            $response = $staticPageBuilder->first();
        }
        return $response;
    }

    /**
     * @param array $data
     * @param StaticPageType $staticPageType
     * @return array
     */
    public function storeOrUpdate(array $data, StaticPageType $staticPageType): array
    {
        $staticPage = null;
        $message = "";
        $databaseOperationType = null;
        $data['static_page_type_id'] = $staticPageType['id'];
        if (!empty($staticPageType->type) && $staticPageType->type == StaticPageType::TYPE_STATIC_PAGE) {
            $staticPage = StaticPageContent::where('static_page_type_id',$staticPageType->id)->first();

            /**
             * If static_page_content already exist then update the static page content.
             * If not then, create new static_page_content.
             */
            if(!$staticPage) {
                $staticPage = new StaticPageContent();
                $message = "Successfully created Static Page Content";
                $databaseOperationType = StaticPageType::DB_OPERATION_CREATE;
            } else{
                $message = "Successfully updated Static Page Content";
                $databaseOperationType = StaticPageType::DB_OPERATION_UPDATE;
            }

            $staticPage->fill($data);
            $staticPage->save();

            /** Now set the static_page type to fetch other_language_fields in StaticPageContentOrBlockResource */
            $staticPage->type = StaticPageType::TYPE_STATIC_PAGE;

        } else if (!empty($staticPageType->type) && $staticPageType->type == StaticPageType::TYPE_PAGE_BLOCK) {
            $staticPage = StaticPageBlock::where('static_page_type_id',$staticPageType->id)->first();

            /**
             * If static_page_block already exist then update the static page block.
             * If not then,create new static_page_block
             */
            if(!$staticPage) {
                $staticPage = new StaticPageBlock();
                $message = "Successfully created Static Page Block";
                $databaseOperationType = StaticPageType::DB_OPERATION_CREATE;
            }else{
                $message = "Successfully updated Static Page Block";
                $databaseOperationType = StaticPageType::DB_OPERATION_UPDATE;
            }

            $staticPage->fill($data);
            $staticPage->save();

            /** Now set the static_page type to fetch other_language_fields in StaticPageContentOrBlockResource */
            $staticPage->type = StaticPageType::TYPE_PAGE_BLOCK;
        }
        return [
            "data"=>$staticPage,
            "message"=>$message,
            "databaseOperationType"=>$databaseOperationType
        ];
    }


    /**
     * @param string $pageCode
     * @return StaticPageType
     */
    public function getStaticPageTypeBYPageCode(string $pageCode): StaticPageType
    {
        return StaticPageType::where('page_code', $pageCode)->firstOrFail();
    }


    /**
     * @param array $request
     * @param string $languageCode
     * @param StaticPageType $staticPageType
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function languageFieldValidator(array $request, string $languageCode, StaticPageType $staticPageType): \Illuminate\Contracts\Validation\Validator
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
            ]
        ];

        if (!empty($staticPageType->type) && $staticPageType->type == StaticPageType::TYPE_STATIC_PAGE) {
            $rules['title'] = [
                'required',
                'string',
                'max:500',
                'min:2'
            ];
            $rules['sub_title'] = [
                'nullable',
                'string'
            ];
            $rules['content'] = [
                'nullable',
                'string'
            ];
        } else if(!empty($staticPageType->type) && $staticPageType->type == StaticPageType::TYPE_PAGE_BLOCK){
            $rules['title'] = [
                'required',
                'string',
                'max:500',
                'min:2'
            ];
            $rules['content'] = [
                'nullable',
                'string'
            ];
            $rules['button_text'] = [
                'nullable',
                'string'
            ];
            $rules['image_alt_title'] = [
                'nullable',
                'string'
            ];
        }
        return Validator::make($request, $rules, $customMessage);
    }

    /**
     * @param Request $request
     * @param StaticPageType $staticPageType
     * @param null $page_code
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, StaticPageType $staticPageType, $page_code = null): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
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
            'content_en' => [
                'nullable',
                'string'
            ],
            'content' => [
                'nullable',
                'string'
            ],

            'row_status' => [
                'required_if:' . $page_code . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]
        ];

        if (!empty($staticPageType->type) && $staticPageType->type == StaticPageType::TYPE_STATIC_PAGE) {
            $rules['sub_title'] = [
                'nullable',
                'string',
                'max:500',
                'min:2'
            ];
            $rules['sub_title_en'] = [
                'nullable',
                'string',
                'max:500',
                'min:2'
            ];
        } else if (!empty($staticPageType->type) && $staticPageType->type == StaticPageType::TYPE_PAGE_BLOCK) {
            $rules['is_button_available'] = [
                'required',
                'int',
                Rule::in(StaticPageBlock::IS_BUTTON_AVAILABLE)
            ];
            $rules['link'] = [
                'requiredIf:is_button_available,' . StaticPageBlock::IS_BUTTON_AVAILABLE_YES,
                'nullable',
                'string',
                'max:191',
            ];
            $rules['button_text'] = [
                'requiredIf:is_button_available,' . StaticPageBlock::IS_BUTTON_AVAILABLE_YES,
                'nullable',
                'string',
                'max:20'
            ];
            $rules['is_attachment_available'] = [
                'required',
                'integer',
                Rule::in(StaticPageBlock::IS_ATTACHMENT_AVAILABLE)
            ];
            $rules['attachment_type'] = [
                'required_if:is_attachment_available,' . StaticPageBlock::IS_ATTACHMENT_AVAILABLE_YES,
                'nullable',
                'integer',
                Rule::in(StaticPageBlock::ATTACHMENT_TYPES)
            ];
            $rules['image_path'] = [
                'required_if:attachment_type,' . StaticPageBlock::ATTACHMENT_TYPE_IMAGE,
                'nullable'
            ];
            $rules['image_alt_title'] = [
                'required_if:attachment_type,' . StaticPageBlock::ATTACHMENT_TYPE_IMAGE,
                'nullable',
                'string'
            ];
            $rules['template_code'] = [
                'required',
                Rule::in(array_keys(StaticPageBlock::STATIC_PAGE_BLOCK_TEMPLATE_TYPES))
            ];
            if ($request->filled('attachment_type') && $request->input('attachment_type') == !StaticPageBlock::ATTACHMENT_TYPE_IMAGE) {
                $rules['video_url'] = [
                    'required',
                    'string',
                    'max:800'
                ];
                $rules['video_id'] = [
                    'required',
                    'max:300'
                ];
            }
        }

        $rules = array_merge($rules, BaseModel::OTHER_LANGUAGE_VALIDATION_RULES);
        return Validator::make($request->all(), $rules);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'show_in' => 'nullable|integer|gt:0',
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
        ]);
    }
}
