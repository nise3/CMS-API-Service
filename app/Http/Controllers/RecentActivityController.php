<?php

namespace App\Http\Controllers;


use App\Http\Resources\RecentActivityResource;
use App\Models\BaseModel;
use App\Models\RecentActivity;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use App\Services\ContentManagementServices\RecentActivityService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

/**
 *
 */
class RecentActivityController extends Controller
{

    public RecentActivityService $recentActivityService;

    private Carbon $startTime;

    public function __construct(RecentActivityService $recentActivityService)
    {
        $this->startTime = Carbon::now();
        $this->recentActivityService = $recentActivityService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $request->offsetSet(BaseModel::IS_COLLECTION_KEY, BaseModel::IS_COLLECTION_FLAG);
        $filter = $this->recentActivityService->filterValidator($request)->validate();
        $response = RecentActivityResource::collection($this->recentActivityService->getRecentActivityList($filter))->resource;
        $response = getResponse($response->toArray(), $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function read(int $id): JsonResponse
    {
        $response = new RecentActivityResource($this->recentActivityService->getOneRecentActivity($id));
        $response = getResponse($response->toArray(request()), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
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
        $response = new RecentActivityResource($this->recentActivityService->getOneRecentActivity($id));
        $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->recentActivityService->validator($request)->validate();
        $message = "Recent Activity is Successfully added";
        $otherLanguagePayload = $validated['other_language_fields'] ?? [];

        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        DB::beginTransaction();
        try {
            $recentActivity = $this->recentActivityService->store($validated);
            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->recentActivityService->languageFieldValidator($value, $key)->validate();
                    foreach (RecentActivity::RECENT_ACTIVITY_LANGUAGE_FILLABLE as $fillableColumn) {
                        if (isset($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload[] = [
                                "table_name" => $recentActivity->getTable(),
                                "key_id" => $recentActivity->id,
                                "lang_code" => $key,
                                "column_name" => $fillableColumn,
                                "column_value" => $languageValidatedData[$fillableColumn]
                            ];
                            app(CmsLanguageService::class)->store($languageFillablePayload);
                        }
                    }

                }

            }



            $response = new RecentActivityResource($recentActivity);
            $response = getResponse($recentActivity->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return Response::json($response, ResponseAlias::HTTP_CREATED);
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
        $recentActivity = RecentActivity::findOrFail($id);
        $validated = $this->recentActivityService->validator($request, $id)->validate();
        $message = "Recent Activity is Successfully Updated";
        $otherLanguagePayload = $validated['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        DB::beginTransaction();
        try {
            $recentActivity = $this->recentActivityService->update($recentActivity, $validated);
            if ($isLanguage) {
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->recentActivityService->languageFieldValidator($value, $key)->validate();
                    foreach (RecentActivity::RECENT_ACTIVITY_LANGUAGE_FILLABLE as $fillableColumn) {
                        if (isset($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload = [
                                "table_name" => $recentActivity->getTable(),
                                "key_id" => $recentActivity->id,
                                "lang_code" => $key,
                                "column_name" => $fillableColumn,
                                "column_value" => $languageValidatedData[$fillableColumn]
                            ];
                            app(CmsLanguageService::class)->store($languageFillablePayload);
                            CmsLanguageService::languageCacheClearByKey($recentActivity->getTable(), $recentActivity->id, $key, $fillableColumn);
                        }
                    }

                }
            }
            $response = getResponse($recentActivity->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
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
        $recentActivity = RecentActivity::findOrFail($id);
        $destroyStatus = $this->recentActivityService->destroy($recentActivity);
        $message = $destroyStatus ? "RecentActivity successfully deleted" : "RecentActivity not deleted";
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
        $recentActivity = RecentActivity::findOrFail($id);

        if ($request->input('status') == BaseModel::STATUS_PUBLISH) {
            $message = "RecentActivity published successfully";
        }
        if ($request->input('status') == BaseModel::STATUS_ARCHIVE) {
            $message = "RecentActivity archived successfully";
        }
        $validatedData = $this->recentActivityService->publishOrArchiveValidator($request)->validate();
        $data = $this->recentActivityService->publishOrArchiveRecentActivity($validatedData, $recentActivity);
        $response = getResponse($data->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

}
