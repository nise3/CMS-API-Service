<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicationResource;
use App\Models\BaseModel;
use App\Models\Publication;

use App\Services\Common\CmsGlobalConfigService;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use App\Services\ContentManagementServices\PublicationService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;


class PublicationController extends Controller
{
    /**
     * @var PublicationService
     */
    public PublicationService $publicationService;

    /**
     * @var Carbon
     */
    private Carbon $startTime;

    /**
     * PublicationController constructor.
     * @param PublicationService $publicationService
     */
    public function __construct(PublicationService $publicationService)
    {
        $this->startTime = Carbon::now();
        $this->publicationService = $publicationService;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws RequestException
     */
    public function getList(Request $request): JsonResponse
    {
        $request->offsetSet(BaseModel::IS_COLLECTION_KEY, BaseModel::IS_COLLECTION_FLAG);
        $filter = $this->publicationService->filterValidator($request)->validate();
        $publicationList = $this->publicationService->getPublicationList($filter);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($publicationList->toArray()['data'] ?? $publicationList->toArray()));
        $response = PublicationResource::collection($publicationList)->resource;
        $response = getResponse($response->toArray(), $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws RequestException
     */
    public function clientSideGetList(Request $request): JsonResponse
    {
        $request->offsetSet(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY, BaseModel::IS_CLIENT_SITE_RESPONSE_FLAG);
        $filter = $this->publicationService->filterValidator($request)->validate();
        $filter[BaseModel::IS_CLIENT_SITE_RESPONSE_KEY] = BaseModel::IS_CLIENT_SITE_RESPONSE_FLAG;
        $publicationList = $this->publicationService->getPublicationList($filter, $this->startTime);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($publicationList->toArray()['data'] ?? $publicationList->toArray()));
        $response = PublicationResource::collection($publicationList)->resource;
        $response = getResponse($response->toArray(), $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);

    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws RequestException
     */
    public function read(Request $request, int $id): JsonResponse
    {
        $publication = $this->publicationService->getOnePublication($id);
        $response = new  PublicationResource($publication);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($publication->toArray()));
        $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);

    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws RequestException
     */
    public function clientSideRead(Request $request, int $id): JsonResponse
    {
        $request->offsetSet(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY, BaseModel::IS_CLIENT_SITE_RESPONSE_FLAG);
        $publication = $this->publicationService->getOnePublication($id);
        $response = new PublicationResource($publication);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($publication->toArray()));
        $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws Throwable
     */
    function store(Request $request): JsonResponse
    {
        $validated = $this->publicationService->validator($request)->validate();
        $message = "Publication successfully added";
        $otherLanguagePayload = $validated['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        DB::beginTransaction();
        try {
            $publication = $this->publicationService->store($validated);
            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->publicationService->languageFieldValidator($value, $key)->validate();
                    foreach (Publication::PUBLICATION_LANGUAGE_FILLABLE as $fillableColumn) {
                        if (isset($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload[] = [
                                "table_name" => $publication->getTable(),
                                "key_id" => $publication->id,
                                "lang_code" => $key,
                                "column_name" => $fillableColumn,
                                "column_value" => $languageValidatedData[$fillableColumn]
                            ];
                        }
                    }
                }
                app(CmsLanguageService::class)->store($languageFillablePayload);
            }
            $response = new PublicationResource($publication);
            $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);

    }


    /**
     * Update the specified resource in storage
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     * @throws Throwable
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $publication = Publication::findOrFail($id);
        $validated = $this->publicationService->validator($request, $id)->validate();
        $message = "NoticeOrNews Update Successfully Done";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];

        DB::beginTransaction();
        try {
            $publication= $this->publicationService->update($publication, $validated);
            $languageFillablePayload = [];
            foreach ($otherLanguagePayload as $key => $value) {
                $languageValidatedData = $this->publicationService->languageFieldValidator($value, $key)->validate();
                foreach (Publication::PUBLICATION_LANGUAGE_FILLABLE as $fillableColumn) {
                    if (isset($languageValidatedData[$fillableColumn])) {
                        $languageFillablePayload[] = [
                            "table_name" => $publication->getTable(),
                            "key_id" => $publication->id,
                            "lang_code" => $key,
                            "column_name" => $fillableColumn,
                            "column_value" => $languageValidatedData[$fillableColumn]
                        ];
                        CmsLanguageService::languageCacheClearByKey($publication->getTable(), $publication->id, $key, $fillableColumn);
                    }
                }
            }
            app(CmsLanguageService::class)->createOrUpdate($languageFillablePayload, $publication);
            $response = new PublicationResource($publication);
            $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK, $message);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);

    }


    /**
     * Remove the specified resource from storage
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $publication = Publication::findOrFail($id);
        $destroyStatus=$this->publicationService->destroy($publication);
        $message = $publication ? "Publication successfully deleted" : "Publication is not deleted";
        $response = getResponse($destroyStatus, $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK, $message);
        return Response::json($response, ResponseAlias::HTTP_OK);

    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function publishOrArchive(Request $request, int $id): JsonResponse
    {
        $noticeOrNews = Publication::findOrFail($id);

        if ($request->input('status') == BaseModel::STATUS_PUBLISH) {
            $message = "Publication published successfully";
        }
        if ($request->input('status') == BaseModel::STATUS_ARCHIVE) {
            $message = "publication archived successfully";
        }
        $validatedData = $this->publicationService->publishOrArchiveValidator($request)->validate();
        $data = $this->publicationService->publishOrArchivePublication($validatedData, $noticeOrNews);
        $response = getResponse($data->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
        return Response::json($response, ResponseAlias::HTTP_CREATED);

    }

}
