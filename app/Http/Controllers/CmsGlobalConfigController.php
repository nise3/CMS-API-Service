<?php

namespace App\Http\Controllers;

use App\Services\Common\CmsGlobalConfigService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CmsGlobalConfigController extends Controller
{
    public CmsGlobalConfigService $cmsGlobalConfigService;

    /**
     * @param CmsGlobalConfigService $cmsGlobalConfigService
     */
    public function __construct(CmsGlobalConfigService $cmsGlobalConfigService)
    {
        $this->cmsGlobalConfigService = $cmsGlobalConfigService;
    }

    /**
     * @return JsonResponse
     */
    public function getGlobalConfig(): JsonResponse
    {
        $response = $this->cmsGlobalConfigService->getGlobalConfigList();
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
