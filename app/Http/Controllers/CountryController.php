<?php

namespace App\Http\Controllers;

use App\Services\LocationManagementServices\CountryService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class CountryController extends Controller
{
    /**
     * @var CountryService
     */
    public CountryService $countryService;
    private Carbon $startTime;

    /**
     * LocDistrictController constructor.
     * @param CountryService $countryService
     */
    public function __construct(CountryService $countryService)
    {
        $this->startTime = Carbon::now();

        $this->countryService = $countryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->countryService->filterValidator($request)->validate();
        $response = $this->countryService->getAllCountries($filter, $this->startTime);
        return Response::json($response);

    }
}
