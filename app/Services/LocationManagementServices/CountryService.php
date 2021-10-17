<?php

namespace App\Services\LocationManagementServices;

use App\Models\BaseModel;
use App\Models\Country;
use App\Models\LocDistrict;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class CountryService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllCountries(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title'] ?? "";
        $code = $request['code'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Builder $districtsBuilder */
        $builder = Country::select([
            'countries.id',
            'countries.title',
            'countries.title_en',
            'countries.code'
        ]);

        $builder->orderBy('countries.id', $order);

        if (!empty($titleEn)) {
            $builder->where('countries.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $builder->where('countries.title', 'like', '%' . $titleBn . '%');
        }


        /** @var Collection $countries */
        $countries = $builder->get();

        $response['order'] = $order;
        $response['data'] = $countries->toArray()['data'] ?? $countries->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffForHumans(Carbon::now())
        ];

        return $response;
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
            'code' => 'integer',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ]
        ], $customMessage);
    }
}
