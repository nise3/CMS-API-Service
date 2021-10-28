<?php

namespace App\Services\LocationManagementServices;

use App\Models\BaseModel;
use App\Models\LocDistrict;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class LocDistrictService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllDistricts(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title'] ?? "";
        $divisionId = $request['loc_division_id'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Builder $districtsBuilder */
        $districtsBuilder = LocDistrict::select([
            'loc_districts.id',
            'loc_districts.loc_division_id',
            'loc_districts.title',
            'loc_districts.title_en',
            'loc_districts.bbs_code',
            'loc_districts.is_sadar_district',
            'loc_divisions.title as division_title',
            'loc_divisions.title_en as division_title_en',

        ]);

        $districtsBuilder->leftJoin('loc_divisions', function ($join) {
            $join->on('loc_divisions.id', '=', 'loc_districts.loc_division_id')
                ->whereNull('loc_divisions.deleted_at');
        });

        $districtsBuilder->orderBy('loc_districts.id', $order);

        if (!empty($titleEn)) {
            $districtsBuilder->where('loc_districts.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $districtsBuilder->where('loc_districts.title', 'like', '%' . $titleBn . '%');
        }

        if (is_numeric($divisionId)) {
            $districtsBuilder->where('loc_districts.loc_division_id', $divisionId);
        }

        /** @var Collection $districts */
        $districts = $districtsBuilder->get();

        $response['order'] = $order;
        $response['data'] = $districts->toArray()['data'] ?? $districts->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffForHumans(Carbon::now())
        ];

        return $response;
    }

    /**
     * @param int $id
     * @param Carbon $startTime
     * @return array
     */
    public function getOneDistrict(int $id, Carbon $startTime): array
    {
        /** @var Builder $districtBuilder */
        $districtBuilder = LocDistrict::select([
            'loc_districts.id',
            'loc_districts.loc_division_id',
            'loc_districts.title',
            'loc_districts.title_en',
            'loc_districts.bbs_code',
            'loc_districts.is_sadar_district',
            'loc_divisions.title as division_title',
            'loc_divisions.title_en as division_title_en'
        ]);

        $districtBuilder->leftJoin('loc_divisions', function ($join) {
            $join->on('loc_divisions.id', '=', 'loc_districts.loc_division_id')
                ->whereNull('loc_divisions.deleted_at');
        });

        $districtBuilder->where('loc_districts.id', $id);

        /** @var LocDistrict $district */
        $district = $districtBuilder->first();

        return [
            "data" => $district ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffForHumans(Carbon::now())
            ]
        ];
    }

    /**
     * @param array $data
     * @return LocDistrict
     */
    public function store(array $data): LocDistrict
    {
        $locDistrict = new LocDistrict();
        $locDistrict->fill($data);
        $locDistrict->save();
        return $locDistrict;
    }

    /**
     * @param LocDistrict $locDistrict
     * @param array $data
     * @return LocDistrict
     */
    public function update(LocDistrict $locDistrict, array $data): LocDistrict
    {
        $locDistrict->fill($data);
        $locDistrict->save();
        return $locDistrict;
    }

    /**
     * @param LocDistrict $locDistrict
     * @return bool
     */
    public function destroy(LocDistrict $locDistrict): bool
    {
        return $locDistrict->delete();
    }

    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];
        return Validator::make($request->all(), [
            'loc_division_id' => 'required|integer|exists:loc_divisions,id',
            'title_en' => 'required|string|max:250|min:2',
            'title' => 'required|string|max:500|min:2',
            'bbs_code' => 'nullable|max:5|min:1'
        ], $customMessage);
    }

    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }

        $customMessage = [
            'order.in' => [
                'code' => 30000,
                "message" => 'Order must be within ASC or DESC',
            ]
        ];

        return Validator::make($request->all(), [
            'title_en' => 'nullable|max:250|min:2',
            'title' => 'nullable|max:500|min:2',
            'loc_division_id' => 'integer|exists:loc_divisions,id',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ]
        ], $customMessage);
    }
}
