<?php


namespace App\Services\LocationManagementServices;


use App\Models\BaseModel;
use App\Models\LocUnion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response;


class LocUnionService
{

    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllUnions(array $request, Carbon $startTime): array
    {

        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title'] ?? "";
        $districtId = $request['loc_district_id'] ?? "";
        $divisionId = $request['loc_division_id'] ?? "";
        $upazilaId = $request['loc_upazila_id'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var LocUnion|Builder $upazilasBuilder */
        $unionBuilder = LocUnion::select([
            'loc_unions.id',
            'loc_unions.title',
            'loc_unions.title_en',
            'loc_unions.bbs_code',
            'loc_unions.loc_district_id',
            'loc_districts.title as district_title',
            'loc_districts.title_en as district_title_en',
            'loc_unions.loc_division_id',
            'loc_divisions.title as division_title',
            'loc_divisions.title_en as division_title_en',
            'loc_unions.loc_upazila_id',
            'loc_upazilas.title as upazila_title',
            'loc_upazilas.title_en as upazila_title_en',
        ]);

        $unionBuilder->leftJoin('loc_divisions', function ($join) {
            $join->on('loc_divisions.id', '=', 'loc_unions.loc_division_id')
                ->whereNull('loc_divisions.deleted_at');
        });

        $unionBuilder->leftJoin('loc_districts', function ($join) {
            $join->on('loc_unions.loc_district_id', '=', 'loc_districts.id')
                ->whereNull('loc_districts.deleted_at');
        });

        $unionBuilder->leftJoin('loc_upazilas', function ($join) {
            $join->on('loc_unions.loc_upazila_id', '=', 'loc_upazilas.id')
                ->whereNull('loc_upazilas.deleted_at');
        });

        $unionBuilder->orderBy('loc_unions.id', $order);

        if (!empty($titleEn)) {
            $unionBuilder->where('loc_unions.title_en', 'like', '%' . $titleEn . '%');
        }

        if (!empty($titleBn)) {
            $unionBuilder->where('loc_unions.title', 'like', '%' . $titleBn . '%');
        }

        if (is_numeric($districtId)) {
            $unionBuilder->where('loc_unions.loc_district_id', $districtId);
        }

        if (is_numeric($divisionId)) {
            $unionBuilder->where('loc_unions.loc_division_id', $divisionId);
        }

        if (is_numeric($upazilaId)) {
            $unionBuilder->where('loc_unions.loc_upazila_id', $upazilaId);
        }

        /** @var LocUnion $upazilas */
        $unions = $unionBuilder->get();

        $response['order'] = $order;
        $response['data'] = $unions->toArray();
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
    #[ArrayShape(["data" => "\App\Models\LocUnion|\stdClass", "_response_status" => "array"])]
    public function getOneUnion(int $id, Carbon $startTime): array
    {
        /** @var LocUnion|Builder $upazilaBuilder */
        $unionBuilder = LocUnion::select([
            'loc_unions.id',
            'loc_unions.loc_district_id',
            'loc_unions.loc_division_id',
            'loc_unions.title',
            'loc_unions.title_en',
            'loc_unions.bbs_code',
            'loc_districts.title as district_title',
            'loc_districts.title_en as district_title_en',
            'loc_divisions.title as division_title',
            'loc_divisions.title_en as division_title_en',
            'loc_unions.loc_upazila_id',
            'loc_upazilas.title as upazila_title',
            'loc_upazilas.title_en as upazila_title_en',
        ]);

        $unionBuilder->leftJoin('loc_divisions', function ($join) {
            $join->on('loc_divisions.id', '=', 'loc_unions.loc_division_id')
                ->whereNull('loc_divisions.deleted_at');
        });

        $unionBuilder->leftJoin('loc_districts', function ($join) {
            $join->on('loc_districts.id', '=', 'loc_unions.loc_district_id')
                ->whereNull('loc_districts.deleted_at');
        });

        $unionBuilder->leftJoin('loc_upazilas', function ($join) {
            $join->on('loc_unions.loc_upazila_id', '=', 'loc_upazilas.id')
                ->whereNull('loc_upazilas.deleted_at');
        });

        $unionBuilder->where('loc_unions.id', $id);

        /** @var LocUnion $upazila */
        $upazila = $unionBuilder->firstOrFail();

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
     * @return LocUnion
     */
    public function store(array $data): LocUnion
    {
        $locUnion = new LocUnion();
        $locUnion->fill($data);
        $locUnion->save();

        return $locUnion;
    }

    /**
     * @param $data
     * @param LocUnion $locUnion
     * @return LocUnion
     */
    public function update($data, LocUnion $locUnion): LocUnion
    {
        $locUnion->fill($data);
        $locUnion->save();
        return $locUnion;
    }

    /**
     * @param LocUnion $locUnion
     * @return bool
     */
    public function destroy(LocUnion $locUnion): bool
    {
        return $locUnion->delete();

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
            'loc_district_id' => 'required|integer|exists:loc_districts,id',
            'loc_division_id' => 'required|integer|exists:loc_divisions,id',
            'loc_upazila_id' => 'required|integer|exists:loc_upazilas,id',
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
            'loc_upazila_id' => 'integer|exists:loc_upazilas,id',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
        ], $customMessage);
    }

}
