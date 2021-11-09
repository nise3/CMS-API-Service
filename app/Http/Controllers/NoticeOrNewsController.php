<?php

namespace App\Http\Controllers;

use App\Http\Resources\GalleryAlbumResource;
use App\Http\Resources\NoticeOrNewsResource;
use App\Models\BaseModel;
use App\Models\NoticeOrNews;
use App\Services\Common\CmsGlobalConfigService;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use App\Services\ContentManagementServices\NoticeOrNewsService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class NoticeOrNewsController extends Controller
{
    public NoticeOrNewsService $noticeOrNewsService;

    private Carbon $startTime;

    public function __construct(NoticeOrNewsService $noticeOrNewsService)
    {
        $this->startTime = Carbon::now();
        $this->noticeOrNewsService = $noticeOrNewsService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $request->offsetSet(BaseModel::IS_COLLECTION_KEY, BaseModel::IS_COLLECTION_FLAG);
        $filter = $this->noticeOrNewsService->filterValidator($request)->validate();
        $noticeOrNewsList = $this->noticeOrNewsService->getNoticeOrNewsServiceList($filter);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($noticeOrNewsList->toArray()['data'] ?? $noticeOrNewsList->toArray()));
        $response = NoticeOrNewsResource::collection($noticeOrNewsList)->resource;
        $response = getResponse($response->toArray(), $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function clientSideGetList(Request $request): JsonResponse
    {
        $request->offsetSet(BaseModel::IS_COLLECTION_KEY, BaseModel::IS_COLLECTION_FLAG);
        $filter = $this->noticeOrNewsService->filterValidator($request)->validate();
        $filter[BaseModel::IS_CLIENT_SITE_RESPONSE_KEY] = BaseModel::IS_CLIENT_SITE_RESPONSE_FLAG;
        $noticeOrNewsList = $this->noticeOrNewsService->getNoticeOrNewsServiceList($filter, $this->startTime);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($noticeOrNewsList->toArray()['data'] ?? $noticeOrNewsList->toArray()));
        $response = NoticeOrNewsResource::collection($noticeOrNewsList)->resource;
        $response = getResponse($response->toArray(), $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function read(Request $request, int $id): JsonResponse
    {
        $noticeOrNews = $this->noticeOrNewsService->getOneNoticeOrNewsService($id);
        $response = new  NoticeOrNewsResource($noticeOrNews);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($noticeOrNews->toArray()));
        $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }


    /**
     * Display the specified resource from client site.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function clientSideRead(Request $request, int $id): JsonResponse
    {
        $request->offsetSet(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY, BaseModel::IS_CLIENT_SITE_RESPONSE_FLAG);
        $response = new NoticeOrNewsResource($this->noticeOrNewsService->getOneNoticeOrNewsService($id));
        $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException|Throwable
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->noticeOrNewsService->validator($request)->validate();
        $message = "NoticeOrNews successfully added";
        $otherLanguagePayload = $validated['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));

        DB::beginTransaction();
        try {
            $noticeOrNews = $this->noticeOrNewsService->store($validated);
            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->noticeOrNewsService->languageFieldValidator($value, $key)->validate();
                    foreach (NoticeOrNews::NOTICE_OR_NEWS_LANGUAGE_FILLABLE as $fillableColumn) {
                        if (isset($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload[] = [
                                "table_name" => $noticeOrNews->getTable(),
                                "key_id" => $noticeOrNews->id,
                                "lang_code" => $key,
                                "column_name" => $fillableColumn,
                                "column_value" => $languageValidatedData[$fillableColumn]
                            ];
                            app(CmsLanguageService::class)->store($languageFillablePayload);
                        }
                    }
                }

            }
            $response = getResponse($noticeOrNews->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);

    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $noticeOrNews = NoticeOrNews::findOrFail($id);
        $validatedData = $this->noticeOrNewsService->validator($request, $id)->validate();
        $message = "NoticeOrNews Update Successfully Done";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        DB::beginTransaction();
        try {
            $noticeOrNews = $this->noticeOrNewsService->update($noticeOrNews, $validatedData);
            if ($isLanguage) {

                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->noticeOrNewsService->languageFieldValidator($value, $key)->validate();
                    foreach (NoticeOrNews::NOTICE_OR_NEWS_LANGUAGE_FILLABLE as $fillableColumn) {
                        if (isset($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload = [
                                "table_name" => $noticeOrNews->getTable(),
                                "key_id" => $noticeOrNews->id,
                                "lang_code" => $key,
                                "column_name" => $fillableColumn,
                                "column_value" => $languageValidatedData[$fillableColumn]
                            ];
                            app(CmsLanguageService::class)->createOrUpdate($languageFillablePayload);
                            CmsLanguageService::languageCacheClearByKey($noticeOrNews->getTable(), $noticeOrNews->id, $key, $fillableColumn);
                        }
                    }
                }

            }
            $response = getResponse($noticeOrNews->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK, $message);
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
     * @throws Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        $noticeOrNews = NoticeOrNews::findOrFail($id);
        $destroyStatus = $this->noticeOrNewsService->destroy($noticeOrNews);
        $message = $noticeOrNews ? "NoticeOrNews successfully deleted" : "NoticeOrNews is not deleted";
        $response = getResponse($destroyStatus, $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK, $message);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function publishOrArchive(Request $request, int $id): JsonResponse
    {
        $noticeOrNews = NoticeOrNews::findOrFail($id);

        if ($request->input('status') == 1) {
            $message = "NoticeOrNews published successfully";
        } else {
            $message = "NoticeOrNews archived successfully";
        }
        $data = $this->noticeOrNewsService->publishOrArchive($request, $noticeOrNews);
        $response = [
            '_response_status' => [
                "data" => $data,
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => $message,
                "query_time" => $this->startTime->diffInSeconds(\Illuminate\Support\Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);

    }

}
