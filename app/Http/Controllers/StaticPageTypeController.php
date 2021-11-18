<?php

namespace App\Http\Controllers;

use App\Services\ContentManagementServices\StaticPageTypeService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class StaticPageTypeController extends Controller
{
    public StaticPageTypeService $staticPageTypeService;
    private Carbon $startTime;

    public function __construct(StaticPageTypeService $staticPageTypeService)
    {
        $this->startTime = Carbon::now();
        $this->staticPageTypeService = $staticPageTypeService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->staticPageTypeService->filterValidation($request)->validate();
        $data = $this->staticPageTypeService->getStaticPageTypeList($filter);

        $response = [
            "data" => $data ?: [],
            "_response_status" => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "query_time" => $this->startTime->diffForHumans(Carbon::now())
            ]
        ];
        return Response::json( $response, $response['_response_status']['code']);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function read(Request $request, int $id): JsonResponse
    {
        $data = $this->staticPageTypeService->getOneStaticPageType($id);

        $response = [
            "data" => $data ?: null,
            "_response_status" => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "query_time" => $this->startTime->diffForHumans(Carbon::now())
            ]
        ];
        return Response::json( $response, $response['_response_status']['code']);
    }
}
