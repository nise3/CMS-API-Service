<?php

namespace App\Http\Controllers;

use App\Http\Resources\StaticPageContentOrBlockResource;
use App\Models\BaseModel;
use App\Models\StaticPageBlock;
use App\Models\StaticPageContent;
use App\Models\StaticPageType;
use App\Services\Common\CmsGlobalConfigService;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use App\Services\ContentManagementServices\StaticPageContentOrPageBlockService;
use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class StaticPageContentOrPageBlockController extends Controller
{
    public StaticPageContentOrPageBlockService $staticPageContentOrPageBlockService;
    private Carbon $startTime;


    public function __construct(StaticPageContentOrPageBlockService $staticPageContentOrPageBlockService)
    {
        $this->startTime = Carbon::now();
        $this->staticPageContentOrPageBlockService = $staticPageContentOrPageBlockService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param string $page_code
     * @return JsonResponse
     * @throws RequestException
     * @throws ValidationException
     */
    public function getStaticPageOrBlock(Request $request, string $page_code): JsonResponse
    {
        $filter = $this->staticPageContentOrPageBlockService->filterValidator($request)->validate();
        $staticPageOrBlock = $this->staticPageContentOrPageBlockService->getStaticPageOrBlock($filter, $page_code);

        if(!$staticPageOrBlock){
            $response = getResponse(null, $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
            return Response::json($response, ResponseAlias::HTTP_OK);
        }

        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($staticPageOrBlock->toArray()));
        $response = new StaticPageContentOrBlockResource($staticPageOrBlock);
        $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);

    }

    /**
     * @param Request $request
     * @param string $page_code
     * @return JsonResponse
     * @throws RequestException
     * @throws ValidationException
     */
    public function clientSideGetStaticPageOrBlock(Request $request, string $page_code): JsonResponse
    {
        $request->offsetSet(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY, BaseModel::IS_CLIENT_SITE_RESPONSE_FLAG);
        $filter = $this->staticPageContentOrPageBlockService->filterValidator($request)->validate();
        $filter[BaseModel::IS_CLIENT_SITE_RESPONSE_KEY] = BaseModel::IS_CLIENT_SITE_RESPONSE_FLAG;
        Log::info("xxxxxxxxxx");
        Log::info(json_encode($filter));

        $staticPageOrBlock = $this->staticPageContentOrPageBlockService->getStaticPageOrBlock($filter, $page_code);
        if(!$staticPageOrBlock){
            $response = getResponse(null, $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
            return Response::json($response, ResponseAlias::HTTP_OK);
        }
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($staticPageOrBlock->toArray()['data'] ?? $staticPageOrBlock->toArray()));
        $response = new StaticPageContentOrBlockResource($staticPageOrBlock);
        $response = getResponse($response->toArray($request), $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);

    }

    /**
     * store a new resource  a new resource in database .
     *
     * @param Request $request
     * @param string $page_code
     * @return JsonResponse
     * @throws ValidationException
     * @throws Throwable
     */
    public function createOrUpdateStaticPageOrBlock(Request $request, string $page_code): JsonResponse
    {
        $staticPageType = $this->staticPageContentOrPageBlockService->getStaticPageTypeBYPageCode($page_code);
        $validatedData = $this->staticPageContentOrPageBlockService->validator($request, $staticPageType, $page_code)->validate();
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        DB::beginTransaction();
        try {
            $response = $this->staticPageContentOrPageBlockService->storeOrUpdate($validatedData, $staticPageType);

            $responseModel = $response['data'];
            $message = $response['message'];
            $databaseOperationType = $response['databaseOperationType'];

            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->staticPageContentOrPageBlockService->languageFieldValidator($value, $key, $staticPageType)->validate();

                    /**
                     * Decide weather Language Fillable fields are for StaticPageContent Model "OR" for StaticPageBlock Model
                    */
                    $languageFillableFields = [];
                    if (!empty($staticPageType->type) && $staticPageType->type == StaticPageType::TYPE_STATIC_PAGE) {
                        $languageFillableFields = StaticPageContent::STATIC_PAGE_CONTENT_LANGUAGE_FILLABLE;
                    } else if(!empty($staticPageType->type) && $staticPageType->type == StaticPageType::TYPE_PAGE_BLOCK){
                        $languageFillableFields = StaticPageBlock::STATIC_PAGE_BLOCK_LANGUAGE_FILLABLE;
                    }

                    foreach ($languageFillableFields as $fillableColumn) {
                        if (!empty($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload[] = [
                                "table_name" => $responseModel->getTable(),
                                "key_id" => $responseModel->id,
                                "lang_code" => $key,
                                "column_name" => $fillableColumn,
                                "column_value" => $languageValidatedData[$fillableColumn]
                            ];
                            if($databaseOperationType == StaticPageType::DB_OPERATION_UPDATE){
                                CmsLanguageService::languageCacheClearByKey($responseModel->getTable(), $responseModel->id, $key, $fillableColumn);
                            }
                        }
                    }
                }

                /**
                 * If CREATE Operation then use store().
                 * If not then, use createOrUpdate()
                 */
                if($databaseOperationType == StaticPageType::DB_OPERATION_CREATE){
                    app(CmsLanguageService::class)->store($languageFillablePayload);
                } else if($databaseOperationType == StaticPageType::DB_OPERATION_UPDATE){
                    app(CmsLanguageService::class)->createOrUpdate($languageFillablePayload,$responseModel);
                }
            }
            $response = new StaticPageContentOrBlockResource($responseModel);
            $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
            DB::commit();
        }catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
