<?php


namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\StaticPageType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StaticPageTypeService
{
    /**
     * @param array $request
     * @return Collection|LengthAwarePaginator|array
     */
    public function getStaticPageTypeList(array $request): Collection|LengthAwarePaginator|array
    {
        $titleEn = $request['title_en'] ?? "";
        $title = $request['title'] ?? "";
        $order = $request["order"] ?? "ASC";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";

        /** @var Builder $staticPageTypesBuilder */
        $staticPageTypesBuilder = StaticPageType::select([
            "static_page_types.id",
            "static_page_types.title_en",
            "static_page_types.title",
            "static_page_types.type",
            "static_page_types.page_code",
            "static_page_types.created_at",
            "static_page_types.updated_at",
        ]);

        $staticPageTypesBuilder->orderBy("static_page_types.id", $order);

        if (!empty($titleEn)) {
            $staticPageTypesBuilder->where('static_page_types.title_en', 'like', '%' . $titleEn . '%');
        }

        if (!empty($title)) {
            $staticPageTypesBuilder->where('static_page_types.title', 'like', '%' . $title . '%');
        }

        /** @var StaticPageType $staticPageTypes */
        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $staticPageTypes = $staticPageTypesBuilder->paginate($pageSize);
        } else {
            $staticPageTypes = $staticPageTypesBuilder->get();
        }
        return $staticPageTypes;
    }


    /**
     * @param int $id
     * @return StaticPageType
     */
    public function getOneStaticPageType(int $id): StaticPageType
    {
        /** @var Builder $staticPageTypeBuilder */
        $staticPageTypeBuilder = StaticPageType::select([
            "static_page_types.id",
            "static_page_types.title_en",
            "static_page_types.title",
            "static_page_types.type",
            "static_page_types.page_code",
            "static_page_types.created_at",
            "static_page_types.updated_at"
        ]);
        $staticPageTypeBuilder->where("static_page_types.id", $id);

        /** @var StaticPageType $staticPageType */
        $staticPageType = $staticPageTypeBuilder->firstOrFail();

        return $staticPageType;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function filterValidation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }
        $customMessage = [
            "order.in" => 'The :attribute must be within ASC or DESC.[30000]'
        ];

        $rules = [
            "title" => "nullable",
            "title_en" => "nullable",
            'page' => 'numeric|gt:0',
            'page_size' => 'numeric|gt:0',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ]
        ];
        return Validator::make($request->all(), $rules, $customMessage);
    }

}
