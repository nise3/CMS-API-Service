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
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->recentActivityService->validator($request)->validate();
        $message = "Recent Activity is Successfully added";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];

        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        DB::beginTransaction();
        try {
            $recentActivity = $this->recentActivityService->store($validated);
            if ($isLanguage) {
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->recentActivityService->languageFieldValidator($value, $key)->validate();
                    foreach (RecentActivity::RECENT_ACTIVITY_LANGUAGE_FILLABLE as $fillableColumn) {
                        if (!empty($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload = [
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
            $response = getResponse($recentActivity->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
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
        $message = "Recent Activity  Update is Successfully Done";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        DB::beginTransaction();
        try {
            $recentActivity = $this->recentActivityService->update($recentActivity, $validated);
            if ($isLanguage) {
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->recentActivityService->languageFieldValidator($value, $key)->validate();
                    foreach (RecentActivity::RECENT_ACTIVITY_LANGUAGE_FILLABLE as $fillableColumn) {
                        if (!empty($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload = [
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
            $response = getResponse($recentActivity->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        $recentActivity = $this->recentActivityService->update($recentActivity, $validated);

        return Response::json($response, ResponseAlias::HTTP_CREATED);
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

}
