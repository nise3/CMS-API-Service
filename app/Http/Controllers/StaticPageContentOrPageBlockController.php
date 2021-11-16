<?php

namespace App\Http\Controllers;

use App\Http\Resources\StaticPageContentOrBlockResource;
use App\Models\BaseModel;
use App\Services\Common\CmsGlobalConfigService;
use App\Services\ContentManagementServices\StaticPageContentOrPageBlockService;
use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class StaticPageContentOrPageBlockController extends Controller
{
    public StaticPageContentOrPageBlockService $staticPageContentOrPageBlockService;
    private Carbon $startTime;


    public function __construct(StaticPageContentOrPageBlockService $staticPageContentOrPageBlockService)
    {
        $this->startTime = Carbon::now();
        $this->$staticPageContentOrPageBlockService = $staticPageContentOrPageBlockService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws RequestException
     * @throws ValidationException
     */
    public function getStaticPageOrBlock(Request $request, string $page_code): JsonResponse
    {
        $filter = $this->staticPageContentOrPageBlockService->filterValidator($request)->validate();
        $staticPageOrBlock = $this->staticPageContentOrPageBlockService->getStaticPageOrBlock($filter, $page_code);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($staticPage->toArray()));
//        $response = new StaticPageContentOrBlockResource($staticPage);
        $response = getResponse($staticPageOrBlock->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);

    }

    /**
     * @throws RequestException
     * @throws ValidationException
     */
    public function clientSideGetStaticPageOrBlock(Request $request, string $page_code): JsonResponse
    {
        $request->offsetSet(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY, BaseModel::IS_CLIENT_SITE_RESPONSE_FLAG);
        $filter = $this->staticPageContentOrPageBlockService->filterValidator($request)->validate();
        $filter[BaseModel::IS_CLIENT_SITE_RESPONSE_KEY] = BaseModel::IS_CLIENT_SITE_RESPONSE_FLAG;
        $staticPageOrBlock = $this->staticPageContentOrPageBlockService->getStaticPageOrBlock($filter, $page_code);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($staticPageOrBlock->toArray()['data'] ?? $staticPageOrBlock->toArray()));
//        $response = StaticPageResource::collection($staticPageList)->resource;
        $response = getResponse($staticPageOrBlock->toArray(), $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);

    }

    /**
     * store a new resource  a new resource in database .
     *
     * @return Response
     */
    public function createOrUpdateStaticPageOrBlock()
    {

    }


}
