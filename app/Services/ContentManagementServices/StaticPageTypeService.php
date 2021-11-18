<?php


namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\StaticPageType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
        $category = $request['category'] ?? [];
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
            "static_page_types.category",
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
        if (!empty($category)) {
            $staticPageTypesBuilder->whereIn('static_page_types.category', '=', $category);
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
     * @return Model|Builder
     */
    public function getOneStaticPageType(int $id): Builder|Model
    {
        /** @var Builder $staticPageTypeBuilder */
        $staticPageTypeBuilder = StaticPageType::select([
            "static_page_types.id",
            "static_page_types.title_en",
            "static_page_types.title",
            "static_page_types.category",
            "static_page_types.type",
            "static_page_types.page_code",
            "static_page_types.created_at",
            "static_page_types.updated_at"
        ]);
        $staticPageTypeBuilder->where("static_page_types.id", $id);

        /** @var StaticPageType $staticPageType */
        return $staticPageTypeBuilder->firstOrFail();
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
        if ($request->filled('category')) {
            $category = is_array($request->get('category')) ? $request->get('category') : explode(',', $request->get('category'));
            $request->offsetSet('category', $category);
        }
        $customMessage = [
            "order.in" => 'The :attribute must be within ASC or DESC.[30000]'
        ];

        $rules = [
            "title" => "nullable",
            "category" => 'nullable|array',
            "category.*" => 'nullable|integer',
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
