<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\Slider;
use App\Services\Common\LanguageCodeService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class SliderService
{

    /**
     * @param array $request
     * @param Carbon $startTime
     * @return Collection|LengthAwarePaginator|array
     */
    public function getAllSliders(array $request): Collection|LengthAwarePaginator|array
    {

        $titleEn = $request['title_en'] ?? "";
        $subTitleEn = $request['sub_title_en'] ?? "";
        $titleBn = $request['title'] ?? "";
        $subTitleBn = $request['sub_title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Builder $sliderBuilder */

        $sliderBuilder = Slider::select([
            'sliders.id',
            'sliders.institute_id',
            'sliders.organization_id',
            'sliders.title_en',
            'sliders.title',
            'sliders.sub_title_en',
            'sliders.sub_title',
            'sliders.is_button_available',
            'sliders.link',
            'sliders.button_text',
            'sliders.slider_images',
            'sliders.alt_title_en',
            'sliders.alt_title',
            'sliders.banner_template_code',
            'sliders.row_status',
            'sliders.created_at',
            'sliders.updated_at',

        ]);
        $sliderBuilder->orderBy('sliders.id', $order);

        if (is_numeric($rowStatus)) {
            $sliderBuilder->where('sliders.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $sliderBuilder->where('sliders.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $sliderBuilder->where('sliders.title', 'like', '%' . $titleBn . '%');
        }
        if (!empty($subTitleEn)) {
            $sliderBuilder->where('sliders.sub_title_en', 'like', '%' . $subTitleEn . '%');
        }
        if (!empty($subTitleBn)) {
            $sliderBuilder->where('sliders.sub_title', 'like', '%' . $subTitleBn . '%');
        }


        /** @var Collection $sliders */
        $sliders = [];
        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $sliders = $sliderBuilder->paginate($pageSize);
        } else {
            $sliders = $sliderBuilder->get();
        }

        return $sliders;

    }

    public function getOneSlider(int $id): Slider
    {
        /** @var Builder $sliderBuilder */

        $sliderBuilder = Slider::select([
            'sliders.id',
            'sliders.institute_id',
            'sliders.organization_id',
            'sliders.title_en',
            'sliders.title',
            'sliders.sub_title_en',
            'sliders.sub_title',
            'sliders.is_button_available',
            'sliders.link',
            'sliders.button_text',
            'sliders.slider_images',
            'sliders.alt_title_en',
            'sliders.alt_title',
            'sliders.banner_template_code',
            'sliders.row_status',
            'sliders.created_at',
            'sliders.updated_at',
        ]);
        $sliderBuilder->where('sliders.id', $id);
        /** @var Slider $slider */
        $slider = $sliderBuilder->firstOrFail();
        return $slider;
    }

    /**
     * @param array $data
     * @return Slider
     */
    public function store(array $data): Slider
    {
        $slider = new Slider();
        $slider->fill($data);
        $slider->save();
        return $slider;
    }

    /**
     * @param Slider $slider
     * @param array $data
     * @return Slider
     */
    public function update(Slider $slider, array $data): Slider
    {

        $slider->fill($data);
        $slider->save();
        return $slider;
    }

    /**
     * @param Slider $slider
     * @return bool
     */
    public function destroy(Slider $slider): bool
    {
        return $slider->delete();
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
            'image_alt_title' => [
                'string',
                'nullable'
            ]
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
        if (!empty($request["slider_images"])) {
            $request["slider_images"] = is_array($request['slider_images']) ? $request['slider_images'] : explode(',', $request['slider_images']);
        }
        $customMessage = [
            'row_status.in' => 'The :attribute must be within 1 or 0.[30000]',
            "banner_template_code.in"=>"The :attribute must be with in ".implode(", ",array_keys(Slider::BANNER_TEMPLATE_TYPES)).".[30000]"
        ];
        $rules = [
            'institute_id' => [
                'nullable',
                'int',
            ],
            'organization_id' => [
                'nullable',
                'int',
            ],
            'title_en' => [
                'required',
                'string',
                'max:191',
                'min:2'
            ],
            'title' => [
                'required',
                'string',
                'max:500',
                'min:2'
            ],
            'sub_title_en' => [
                'required',
                'string',
                'max:191',
                'min:2'
            ],
            'sub_title' => [
                'required',
                'string',
                'max:191',
                'min:2'
            ],
            'is_button_available' => [
                'required',
                'int',
                Rule::in([Slider::IS_BUTTON_AVAILABLE_YES, Slider::IS_BUTTON_AVAILABLE_NO])
            ],
            'link' => [
                'nullable',
                'requiredIf:is_button_available,' . Slider::IS_BUTTON_AVAILABLE_YES,
                'string',
                'max:191',
            ],
            'button_text' => [
                'nullable',
                'requiredIf:is_button_available,' . Slider::IS_BUTTON_AVAILABLE_YES,
                'string',
                'max:20'
            ],
            'slider_images' => [
                'required',
                'array',
            ],
            'slider_images.*' => [
                'string',
            ],
            'alt_title_en' => [
                'string',
                'nullable'
            ],
            'alt_title' => [
                'string',
                'nullable'
            ],
            "banner_template_code" => [
                "nullable",
                Rule::in(array_keys(Slider::BANNER_TEMPLATE_TYPES))
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
            'page' => 'numeric|gt:0',
            'page_size' => 'numeric|gt:0',
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
