<?php

namespace App\Services\ContentManagementServices;


use App\Models\BaseModel;
use App\Models\Nise3Partner;
use App\Models\Slider;
use App\Services\Common\LanguageCodeService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use stdClass;
use Symfony\Component\HttpFoundation\Response;


class Nise3PartnerService
{

    /**
     * @param array $request
     * @return Collection|LengthAwarePaginator|array
     */
    public function getPartnerList(array $request): Collection|LengthAwarePaginator|array
    {
        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request["order"] ?? "ASC";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";

        /** @var Builder $nise3PartnerBuilder */
        $nise3PartnerBuilder = Nise3Partner::select([
            "nise3_partners.id",
            "nise3_partners.title_en",
            "nise3_partners.title",
            "nise3_partners.main_image_path",
            "nise3_partners.thumb_image_path",
            "nise3_partners.grid_image_path",
            "nise3_partners.domain",
            "nise3_partners.image_alt_title_en",
            "nise3_partners.image_alt_title",
            "nise3_partners.row_status",
            "nise3_partners.created_by",
            "nise3_partners.updated_by",
            "nise3_partners.created_at",
            "nise3_partners.updated_at",
        ]);

        $nise3PartnerBuilder->orderBy("nise3_partners.id", $order);

        if (is_numeric($rowStatus)) {
            $nise3PartnerBuilder->where('nise3_partners.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $nise3PartnerBuilder->where("nise3_partners.title_en", "=", $titleEn);
        }

        if (!empty($titleBn)) {
            $nise3PartnerBuilder->where("nise3_partners.title_en", "=", $titleBn);
        }

        /** @var Nise3Partner $nise3Partners */
        $nise3Partners = [];
        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $nise3Partners = $nise3PartnerBuilder->paginate($pageSize);
        } else {
            $nise3Partners = $nise3PartnerBuilder->get();
        }
        return $nise3Partners;
    }


    /**
     * @param int $id
     * @param Carbon $startTime
     * @return Nise3Partner
     */
    public function getOnePartner(int $id): Nise3Partner
    {
        /** @var Builder $nise3PartnerBuilder */
        $nise3PartnerBuilder = Nise3Partner::select([
            "nise3_partners.id",
            "nise3_partners.title_en",
            "nise3_partners.title",
            "nise3_partners.main_image_path",
            "nise3_partners.thumb_image_path",
            "nise3_partners.grid_image_path",
            "nise3_partners.domain",
            "nise3_partners.image_alt_title_en",
            "nise3_partners.image_alt_title",
            "nise3_partners.row_status",
            "nise3_partners.created_by",
            "nise3_partners.updated_by",
            "nise3_partners.created_at",
            "nise3_partners.updated_at",
        ]);
        $nise3PartnerBuilder->where("nise3_partners.id", $id);

        /** @var Nise3Partner $nise3Partner */
        $nise3Partner = $nise3PartnerBuilder->firstOrFail();

        return $nise3Partner;
    }

    /**
     * @param array $data
     * @return Nise3Partner
     */
    public function store(array $data): Nise3Partner
    {
        $nise3Partner = app(Nise3Partner::class);
        $nise3Partner->fill($data);
        $nise3Partner->save();
        return $nise3Partner;
    }

    /**
     * @param Nise3Partner $partner
     * @param array $data
     * @return Nise3Partner
     */
    public function update(Nise3Partner $nise3Partner, array $data): Nise3Partner
    {
        $nise3Partner->fill($data);
        $nise3Partner->save();
        return $nise3Partner;
    }

    /**
     * @param Nise3Partner $partner
     * @return bool
     */
    public function destroy(Nise3Partner $partner): bool
    {
        return $partner->delete();
    }

    public function languageFieldValidator(array $request, string $languageCode): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'required' => 'The :attribute_' . strtolower($languageCode) . ' in other language fields is required.[50000]',
            'max' => 'The :attribute_' . strtolower($languageCode) . ' in other language fields must not be greater than :max characters.[39003]',
            'min' => 'The :attribute_' . strtolower($languageCode) . ' in other language fields must be at least :min characters.[42003]',
            'language_code.regex' => "The language  code " . $languageCode . " must be lowercase.[48000]",
            'language_code.in' => "The language with code " . $languageCode . " is not allowed.[30000]",
        ];
        $request['language_code'] = $languageCode;
        $rules = [
            "language_code" => [
                "required",
                "regex:/[a-z]$/",
                Rule::in(LanguageCodeService::getLanguageCode()),
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
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            "regex" => "The :attribute format will be a uri with http/https.[48000]",
            'row_status.in' => 'The :attribute must be within 1 or 0'
        ];
        $rules = [
            "title_en" => "required|max:191|min:2",
            "title" => "required|max:500|min:2",
            "main_image_path" => [
                "nullable",
                BaseModel::IMAGE_PATH_VALIDATION_RULE
            ],
            "thumb_image_path" => [
                "nullable",
                BaseModel::IMAGE_PATH_VALIDATION_RULE
            ],
            "grid_image_path" => [
                "nullable",
                BaseModel::IMAGE_PATH_VALIDATION_RULE
            ],
            "domain" => [
                "nullable",
                BaseModel::HTTP_URL
            ],
            "image_alt_title_en" => "nullable|min:2|max:191",
            "image_alt_title" => "nullable|min:2|max:191",
            "created_by" => "nullable|numeric|gt:0",
            "updated_by" => "nullable|numeric|gt:0",
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
    public function filterValidation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }
        $customMessage = [
            "order.in" => 'The :attribute must be within ASC or DESC.[30000]',
            'row_status.in' => 'The :attribute must be within 1 or 0.[30000]'
        ];

        $rules = [
            "title_en" => "nullable",
            "title" => "nullable",
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
        ];
        return Validator::make($request->all(), $rules, $customMessage);
    }

}
