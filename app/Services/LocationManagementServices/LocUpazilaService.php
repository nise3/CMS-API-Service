<?php


namespace App\Services\LocationManagementServices;


use App\Models\BaseModel;
use App\Models\LocUpazila;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;


class LocUpazilaService
{

    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllUpazilas(array $request, Carbon $startTime): array
    {

        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title'] ?? "";
        $districtId = $request['loc_district_id'] ?? "";
        $divisionId = $request['loc_division_id'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var LocUpazila|Builder $upazilasBuilder */
        $upazilasBuilder = LocUpazila::select([
            'loc_upazilas.id',
            'loc_upazilas.title',
            'loc_upazilas.title_en',
            'loc_upazilas.bbs_code',
            'loc_upazilas.loc_district_id',
            'loc_districts.title as district_title',
            'loc_districts.title_en as district_title_en',
            'loc_upazilas.loc_division_id',
            'loc_divisions.title as division_title',
            'loc_divisions.title_en as division_title_en'
        ]);

        $upazilasBuilder->leftJoin('loc_divisions', function ($join) {
            $join->on('loc_divisions.id', '=', 'loc_upazilas.loc_division_id')
                ->whereNull('loc_divisions.deleted_at');
        });

        $upazilasBuilder->leftJoin('loc_districts', function ($join) {
            $join->on('loc_upazilas.loc_district_id', '=', 'loc_districts.id')
                ->whereNull('loc_districts.deleted_at');
        });

        $upazilasBuilder->orderBy('loc_upazilas.id', $order);

        if (!empty($titleEn)) {
            $upazilasBuilder->where('loc_upazilas.title_en', 'like', '%' . $titleEn . '%');
        }

        if (!empty($titleBn)) {
            $upazilasBuilder->where('loc_upazilas.title', 'like', '%' . $titleBn . '%');
        }

        if (is_numeric($districtId)) {
            $upazilasBuilder->where('loc_upazilas.loc_district_id', $districtId);
        }

        if (is_numeric($divisionId)) {
            $upazilasBuilder->where('loc_upazilas.loc_division_id', $divisionId);
        }

        /** @var LocUpazila $upazilas */
        $upazilas = $upazilasBuilder->get();

        $response['order'] = $order;
        $response['data'] = $upazilas->toArray()['data'] ?? $upazilas->toArray();
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
    public function getOneUpazila(int $id, Carbon $startTime): array
    {
        /** @var LocUpazila|Builder $upazilaBuilder */
        $upazilaBuilder = LocUpazila::select([
            'loc_upazilas.id',
            'loc_upazilas.loc_district_id',
            'loc_upazilas.loc_division_id',
            'loc_upazilas.title',
            'loc_upazilas.title_en',
            'loc_upazilas.bbs_code',
            'loc_districts.title as district_title',
            'loc_districts.title_en as district_title_en',
            'loc_divisions.title as division_title',
            'loc_divisions.title_en as division_title_en'
        ]);

        $upazilaBuilder->leftJoin('loc_divisions', function ($join) {
            $join->on('loc_divisions.id', '=', 'loc_upazilas.loc_division_id')
                ->whereNull('loc_divisions.deleted_at');
        });

        $upazilaBuilder->leftJoin('loc_districts', function ($join) {
            $join->on('loc_districts.id', '=', 'loc_upazilas.loc_district_id')
                ->whereNull('loc_districts.deleted_at');
        });

        $upazilaBuilder->where('loc_upazilas.id', $id);

        /** @var LocUpazila $upazila */
        $upazila = $upazilaBuilder->first();

        return [
            "data" => $upazila ?? new \stdClass(),
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffForHumans(Carbon::now())
            ]
        ];
    }

    /**
     * @param array $data
     * @return LocUpazila
     */
    public function store(array $data): LocUpazila
    {
        $locUpazila = new LocUpazila();
        $locUpazila->fill($data);
        $locUpazila->save();

        return $locUpazila;
    }

    /**
     * @param $data
     * @param LocUpazila $locUpazila
     * @return LocUpazila
     */
    public function update($data, LocUpazila $locUpazila): LocUpazila
    {
        $locUpazila->fill($data);
        $locUpazila->save();
        return $locUpazila;
    }

    /**
     * @param LocUpazila $locUpazila
     * @return bool
     */
    public function destroy(LocUpazila $locUpazila): bool
    {
        return $locUpazila->delete();

    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];
        return Validator::make($request->all(), [
            'loc_district_id' => 'required|numeric|exists:loc_districts,id',
            'loc_division_id' => 'required|numeric|exists:loc_divisions,id',
            'title_en' => 'required|string|max:250|min:2',
            'title' => 'required|string|max:500|min:2',
            'bbs_code' => 'nullable|max:6|min:1'
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
            'loc_district_id' => 'integer|exists:loc_districts,id',
            'loc_division_id' => 'integer|exists:loc_divisions,id',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
        ], $customMessage);
    }

}
