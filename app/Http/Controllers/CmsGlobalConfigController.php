<?php

namespace App\Http\Controllers;

use App\Services\Common\CmsGlobalConfigService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CmsGlobalConfigController extends Controller
{
    public CmsGlobalConfigService $cmsGlobalConfigService;

    private Carbon $startTime;

    /**
     * @param CmsGlobalConfigService $cmsGlobalConfigService
     * @param Carbon $startTime
     */
    public function __construct(CmsGlobalConfigService $cmsGlobalConfigService,Carbon $startTime)
    {
        $this->cmsGlobalConfigService = $cmsGlobalConfigService;
        $this->startTime = $startTime;
    }

    /**
     * @return JsonResponse
     */
    public function getGlobalConfig(): JsonResponse
    {
        $response = [
            '_response_status' => [
                'data' => $this->cmsGlobalConfigService->getGlobalConfigList(),
                "success" => false,
                "code" => ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                "message" => "User is not created",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, $response['_response_status']['code']);
    }
}
