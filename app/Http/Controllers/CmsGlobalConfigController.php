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
    public function __construct(CmsGlobalConfigService $cmsGlobalConfigService, Carbon $startTime)
    {
        $this->cmsGlobalConfigService = $cmsGlobalConfigService;
        $this->startTime = $startTime;
    }

    /**
     * @return JsonResponse
     */
    public function getGlobalConfig(): JsonResponse
    {
        $response = getResponse($this->cmsGlobalConfigService->getGlobalConfigList(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response,ResponseAlias::HTTP_OK);
    }
}
