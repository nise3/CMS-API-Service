<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\Banner;
use App\Services\Common\LanguageCodeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BannerService
{

    /**
     * @param array $request
     * @return Collection|LengthAwarePaginator|array
     */
    public function getAllBanners(array $request): Collection|LengthAwarePaginator|array
    {

        $titleEn = $request['title_en'] ?? "";
        $subTitleEn = $request['sub_title_en'] ?? "";
        $titleBn = $request['title'] ?? "";
        $subTitleBn = $request['sub_title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $isRequestFromClientSide = !empty($request[BaseModel::IS_CLIENT_SITE_RESPONSE_KEY]);

        /** @var Builder $bannerBuilder */

        $bannerBuilder = Banner::select([
            'banners.id',
            'banners.slider_id',
            'sliders.organization_id',
            'sliders.institute_id',
            'banners.title',
            'banners.sub_title',
            'banners.is_button_available',
            'banners.button_text',
            'banners.link',
            'banners.alt_image_title',
            'banners.banner_template_code',
            'banners.row_status',
            'banners.created_by',
            'banners.updated_by',
            'banners.created_at',
            'banners.updated_at',

        ]);
        $bannerBuilder->join('sliders', function ($join) {
            $join->on('banners.slider_id', '=', 'sliders.id')
                ->whereNull('sliders.deleted_at');
        });
        $bannerBuilder->orderBy('banners.id', $order);


        if ($isRequestFromClientSide) {
            $bannerBuilder->active();
        }

        if (is_numeric($rowStatus)) {
            $bannerBuilder->where('banners.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $bannerBuilder->where('banners.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $bannerBuilder->where('banners.title', 'like', '%' . $titleBn . '%');
        }
        if (!empty($subTitleEn)) {
            $bannerBuilder->where('banners.sub_title_en', 'like', '%' . $subTitleEn . '%');
        }
        if (!empty($subTitleBn)) {
            $bannerBuilder->where('banners.sub_title', 'like', '%' . $subTitleBn . '%');
        }


        /** @var Collection $banners */
        $banners = [];
        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $banners = $bannerBuilder->paginate($pageSize);
        } else {
            $banners = $bannerBuilder->get();
        }

        return $banners;

    }

    public function getOneBanner(int $id): Builder|Model
    {
        /** @var Builder $bannerBuilder */

        $bannerBuilder = Banner::select([
            'banners.id',
            'banners.slider_id',
            'sliders.organization_id',
            'sliders.institute_id',
            'banners.title',
            'banners.sub_title',
            'banners.is_button_available',
            'banners.button_text',
            'banners.link',
            'banners.alt_image_title',
            'banners.banner_template_code',
            'banners.row_status',
            'banners.created_by',
            'banners.updated_by',
            'banners.created_at',
            'banners.updated_at',
        ]);
        $bannerBuilder->join('sliders', function ($join) {
            $join->on('banners.slider_id', '=', 'sliders.id')
                ->whereNull('sliders.deleted_at');
        });
        $bannerBuilder->where('banners.id', $id);
        /** @var Banner $banner */
        return $bannerBuilder->firstOrFail();
    }

    /**
     * @param array $data
     * @return Banner
     */
    public function store(array $data): Banner
    {
        $banner = new Banner();
        $banner->fill($data);
        $banner->save();
        return $banner;
    }

    /**
     * @param Banner $banner
     * @param array $data
     * @return Banner
     */
    public function update(Banner $banner, array $data): Banner
    {

        $banner->fill($data);
        $banner->save();
        return $banner;
    }

    /**
     * @param Banner $banner
     * @return bool
     */
    public function destroy(Banner $banner): bool
    {
        return $banner->delete();
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
                'required',
                'string',
                'max:191',
                'min:2'
            ],
            'button_text' => [
                'nullable',
                'string',
                'max:20'
            ],
            'alt_image_title' => [
                'string',
                'nullable'
            ],
        ];
        return Validator::make($request, $rules, $customMessage);
    }

    /**
     * @param $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator($request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => 'The :attribute must be within 1 or 0.[30000]',
            "banner_template_code.in" => "The :attribute must be with in " . implode(", ", array_keys(Banner::BANNER_TEMPLATE_TYPES)) . ".[30000]"
        ];
        $rules = [
            'slider_id' => [
                'required',
                'integer',
                'exists:sliders,id,deleted_at,NULL'
            ],
            'title' => [
                'required',
                'string',
                'max:500',
                'min:2'
            ],
            'sub_title' => [
                'required',
                'string',
                'max:300',
                'min:2'
            ],
            'is_button_available' => [
                'required',
                'int',
                Rule::in([Banner::IS_BUTTON_AVAILABLE_YES, Banner::IS_BUTTON_AVAILABLE_NO])
            ],
            'link' => [
                'nullable',
                'requiredIf:is_button_available,' . Banner::IS_BUTTON_AVAILABLE_YES,
                'string',
                'max:191',
            ],
            'button_text' => [
                'nullable',
                'requiredIf:is_button_available,' . Banner::IS_BUTTON_AVAILABLE_YES,
                'string',
                'max:20'
            ],
            'alt_image_title' => [
                'string',
                'nullable'
            ],
            "banner_template_code" => [
                "nullable",
                Rule::in(array_keys(Banner::BANNER_TEMPLATE_TYPES))
            ],
            "banner_image_url" => [
                "required",
                "string",
                "max:600"
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]

        ];

        $rules = array_merge($rules, BaseModel::OTHER_LANGUAGE_VALIDATION_RULES);

        return Validator::make($request->all(), $rules, $customMessage);
    }


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

        return Validator::make($request->all(), [
            'title_en' => 'nullable|max:191|min:2',
            'sub_title_en' => 'nullable|max:500|min:2',
            'title' => 'nullable|max:191|min:2',
            'sub_title' => 'nullable|max:500|min:2',
            'page' => 'nullable|numeric|gt:0',
            'page_size' => 'nullable|numeric|gt:0',
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
