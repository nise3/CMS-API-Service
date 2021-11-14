<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\Slider;
use App\Models\StaticPage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpParser\Builder;

class SliderService
{
    public function getSliderList(array $request): Collection|LengthAwarePaginator|array
    {

        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $instituteId = $request['institute_id'] ?? "";
        $organizationId = $request['organization_id'] ?? "";
        $industryAssociationId = $request['industry_association_id'] ?? "";
        $showIn = $request['show_in'] ?? "";
        $isRequestFromClientSide = !empty($request[BaseModel::IS_CLIENT_SITE_RESPONSE_KEY]);

        $sliderBuilder = Slider::select([
            'sliders.id',
            'sliders.show_in',
            'sliders.organization_id',
            'sliders.institute_id',
            'sliders.row_status',
            'sliders.row_status',
            'sliders.created_by',
            'sliders.updated_by',
            'sliders.created_at',
            'sliders.updated_at'
        ]);

        $sliderBuilder->orderBy('sliders.id', $order);
        if (is_numeric($instituteId)) {
            $sliderBuilder->where('sliders.institute_id', '=', $instituteId);
        }

        if (is_numeric($organizationId)) {
            $sliderBuilder->where('sliders.organization_id', '=', $organizationId);
        }

        if (is_numeric($rowStatus)) {
            $sliderBuilder->where('sliders.row_status', '=', $rowStatus);
        }


        if (is_numeric($showIn)) {
            $sliderBuilder->where('sliders.show_in', '=', $showIn);
        }

        /** @var Collection $sliders */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $sliders = $sliderBuilder->paginate($pageSize);
        } else {
            $sliders = $sliderBuilder->get();
        }

        return $sliders;
    }

    public function getOneSlider($id): Builder|Model
    {
        $sliderBuilder = Slider::select([
            'sliders.id',
            'sliders.show_in',
            'sliders.organization_id',
            'sliders.institute_id',
            'sliders.row_status',
            'sliders.row_status',
            'sliders.created_by',
            'sliders.updated_by',
            'sliders.created_at',
            'sliders.updated_at'
        ]);

        $sliderBuilder->where('sliders.id', $id);

        /** @var Slider $slider */
        return $sliderBuilder->firstOrFail();
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
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];
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
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]
        ];
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
