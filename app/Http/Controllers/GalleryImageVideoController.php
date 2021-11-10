<?php

namespace App\Http\Controllers;

use App\Http\Resources\GalleryImageVideoResource;
use App\Models\BaseModel;
use App\Models\GalleryImageVideo;
use App\Services\Common\CmsGlobalConfigService;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use App\Services\ContentManagementServices\GalleryImageVideoService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

/**
 * Class GalleryImageVideoController
 * @package App\Http\Controllers
 */
class GalleryImageVideoController extends Controller
{


    public GalleryImageVideoService $galleryImageVideoService;

    private Carbon $startTime;

    /**
     * GalleryImageVideoController constructor.
     * @param GalleryImageVideoService $galleryImageVideoService
     */
    public function __construct(GalleryImageVideoService $galleryImageVideoService)
    {
        $this->startTime = Carbon::now();
        $this->galleryImageVideoService = $galleryImageVideoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws RequestException
     */
    public function getList(Request $request): JsonResponse
    {
        $request->offsetSet(BaseModel::IS_COLLECTION_KEY, BaseModel::IS_COLLECTION_FLAG);
        $filter = $this->galleryImageVideoService->filterValidator($request)->validate();
        $galleryImageVideoList = $this->galleryImageVideoService->getGalleryImageVideoList($filter);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($galleryImageVideoList->toArray()['data'] ?? $galleryImageVideoList->toArray()));
        $response = GalleryImageVideoResource::collection($galleryImageVideoList)->resource;
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
        $request->offsetSet(BaseModel::IS_COLLECTION_KEY, BaseModel::IS_COLLECTION_FLAG);
        $filter = $this->galleryImageVideoService->filterValidator($request)->validate();
        $filter[BaseModel::IS_CLIENT_SITE_RESPONSE_KEY] = BaseModel::IS_CLIENT_SITE_RESPONSE_FLAG;
        $galleryImageVideoList = $this->galleryImageVideoService->getGalleryImageVideoList($filter, $this->startTime);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($galleryImageVideoList->toArray()['data'] ?? $galleryImageVideoList->toArray()));
        $response = GalleryImageVideoResource::collection($galleryImageVideoList)->resource;
        $response = getResponse($response->toArray(), $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Display the specified resource.$galleryImageVideoList
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws RequestException
     */
    public function read(Request $request, int $id): JsonResponse
    {
        $galleryImageVideo = $this->galleryImageVideoService->getOneGalleryImageVideo($id);
        $response = new  GalleryImageVideoResource($galleryImageVideo);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($galleryImageVideo->toArray()));
        $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }


    /**
     * Display the specified resource from client site.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws RequestException
     */
    public function clientSideRead(Request $request, int $id): JsonResponse
    {
        $request->offsetSet(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY, BaseModel::IS_CLIENT_SITE_RESPONSE_FLAG);
        $galleryImageVideo = $this->galleryImageVideoService->getOneGalleryImageVideo($id);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($galleryImageVideo->toArray()));
        $response = new GalleryImageVideoResource($galleryImageVideo);
        $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $this->galleryImageVideoService->validator($request)->validate();
        $message = "GalleryImageVideo is Successfully added";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];

        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        DB::beginTransaction();
        try {
            $galleryImageVideo = $this->galleryImageVideoService->store($validatedData);
            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->galleryImageVideoService->languageFieldValidator($value, $key)->validate();
                    foreach (GalleryImageVideo::GALLERY_IMAGE_VIDEO_LANGUAGE_FILLABLE as $fillableColumn) {
                        if (!empty($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload[] = [
                                "table_name" => $galleryImageVideo->getTable(),
                                "key_id" => $galleryImageVideo->id,
                                "lang_code" => $key,
                                "column_name" => $fillableColumn,
                                "column_value" => $languageValidatedData[$fillableColumn]
                            ];
                        }

                    }

                }
                app(CmsLanguageService::class)->store($languageFillablePayload);
            }
            $response = new GalleryImageVideoResource($galleryImageVideo);
            $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $galleryImageVideo = GalleryImageVideo::findOrFail($id);
        $validatedData = $this->galleryImageVideoService->validator($request, $id)->validate();
        $message = "GalleryImageVideo Update is Successfully Done";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        DB::beginTransaction();
        try {
            $galleryImageVideo = $this->galleryImageVideoService->update($galleryImageVideo, $validatedData);
            $languageFillablePayload = [];
            foreach ($otherLanguagePayload as $key => $value) {
                $languageValidatedData = $this->galleryImageVideoService->languageFieldValidator($value, $key)->validate();
                foreach (GalleryImageVideo::GALLERY_IMAGE_VIDEO_LANGUAGE_FILLABLE as $fillableColumn) {
                    if (!empty($languageValidatedData[$fillableColumn])) {
                        $languageFillablePayload[] = [
                            "table_name" => $galleryImageVideo->getTable(),
                            "key_id" => $galleryImageVideo->id,
                            "lang_code" => $key,
                            "column_name" => $fillableColumn,
                            "column_value" => $languageValidatedData[$fillableColumn]
                        ];
                        CmsLanguageService::languageCacheClearByKey($galleryImageVideo->getTable(), $galleryImageVideo->id, $key, $fillableColumn);
                    }
                }
            }
            app(CmsLanguageService::class)->createOrUpdate($languageFillablePayload,$galleryImageVideo->id);
            $response = new GalleryImageVideoResource($galleryImageVideo);
            $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK, $message);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $galleryImageVideo = GalleryImageVideo::findOrFail($id);
        $destroyStatus = $this->galleryImageVideoService->destroy($galleryImageVideo);
        $message = $destroyStatus ? "Gallery Image Video successfully deleted" : "Gallery Image Video not deleted";
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
        $galleryImageVideo = GalleryImageVideo::findOrFail($id);

        if ($request->input('status') == BaseModel::STATUS_PUBLISH) {
            $message = "GalleryImageVideo published successfully";
        }
        if ($request->input('status') == BaseModel::STATUS_ARCHIVE) {
            $message = "GalleryImageVideo archived successfully";
        }
        $validatedData = $this->galleryImageVideoService->publishOrArchiveValidator($request)->validate();
        $data = $this->galleryImageVideoService->publishOrArchiveGalleryImageVideo($validatedData, $galleryImageVideo);
        $response = getResponse($data->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
        return Response::json($response, ResponseAlias::HTTP_CREATED);

    }
}
