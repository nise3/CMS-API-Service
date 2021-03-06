<?php

namespace App\Services\LocationManagementServices;

use App\Models\BaseModel;
use App\Models\LocDivision;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LocService
 * @package App\Services\Sevices
 */
class LocDivisionService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllDivisions(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Builder $divisionsBuilder */
        $divisionsBuilder = LocDivision::select([
            'id',
            'title',
            'title_en',
            'bbs_code',
        ]);
        $divisionsBuilder->orderBy('id', $order);

        if (!empty($titleEn)) {
            $divisionsBuilder->where('title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $divisionsBuilder->where('title', 'like', '%' . $titleBn . '%');
        }

        /** @var Collection $divisions */
        $divisions = $divisionsBuilder->get();

        $response['order'] = $order;
        $response['data'] = $divisions->toArray()['data'] ?? $divisions->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffForHumans(Carbon::now())
        ];

        return $response;
    }

    /**
     * @param int $id
     * @return LocDivision
     */
    public function getOneDivision(int $id): LocDivision
    {
        /** @var LocDivision|Builder $divisionsBuilder */
        $divisionBuilder = LocDivision::select([
            'id',
            'title',
            'title_en',
            'bbs_code'
        ]);
        $divisionBuilder->where('id', $id);

        return $divisionBuilder->first();
    }

    /**
     * @param array $data
     * @return LocDivision
     */
    public function store(array $data): LocDivision
    {
        return LocDivision::create($data);
    }

    /**
     * @param array $data
     * @param LocDivision $locDivision
     * @return LocDivision
     */
    public function update(array $data, LocDivision $locDivision): LocDivision
    {
        $locDivision->fill($data);
        $locDivision->save();
        return $locDivision;
    }

    /**
     * @param LocDivision $locDivision
     * @return bool
     */
    public function destroy(LocDivision $locDivision): bool
    {
        return $locDivision->delete();
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [];

        return Validator::make($request->all(), [
            'title_en' => 'required|string|max:250|min:2',
            'title' => 'required|string|max:500|min:2',
            'bbs_code' => 'nullable|max:4|min:1',
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
            'order' => [
                'string',
                Rule::in([(BaseModel::ROW_ORDER_ASC), (BaseModel::ROW_ORDER_DESC)])
            ],
        ], $customMessage);
    }
}
