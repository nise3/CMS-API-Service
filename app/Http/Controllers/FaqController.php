<?php

namespace App\Http\Controllers;

use App\Http\CustomInterfaces\Contract\ResourceInterface;
use App\Http\Resources\FaqResource;
use App\Models\BaseModel;
use App\Models\Faq;
use App\Models\LanguageCode;
use App\Models\LanguageConfig;
use App\Models\Slider;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use App\Services\ContentManagementServices\FaqService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class FaqController extends Controller implements ResourceInterface
{
    public FaqService $faqService;
    private Carbon $startTime;

    public function __construct(FaqService $faqService)
    {
        $this->startTime = Carbon::now();
        $this->faqService = $faqService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws Throwable
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->faqService->filterValidator($request)->validate();
        $response = FaqResource::collection($this->faqService->getFaqList($filter))->resource;
        $response = getResponse($response->toArray(), $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function read(Request $request, int $id): JsonResponse
    {
        $response = new FaqResource($this->faqService->getOneFaq($id));
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
    public function clientSiteRead(Request $request, int $id): JsonResponse
    {
        $response = new FaqResource($this->faqService->getOneFaq($id));
        $request->offsetSet(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY, BaseModel::IS_CLIENT_SITE_RESPONSE_FLAG);
        $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws Throwable
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $this->faqService->validator($request)->validate();
        $message = "Faq successfully added";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        $response = [];
        DB::beginTransaction();
        try {
            $faq = $this->faqService->store($validatedData);
            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->faqService->languageFieldValidator($value, $key)->validate();
                    foreach (Faq::FAQ_LANGUAGE_FILLABLE as $fillableColumn) {
                        if (!empty($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload[] = [
                                "table_name" => $faq->getTable(),
                                "key_id" => $faq->id,
                                "lang_code" => $key,
                                "column_name" => $fillableColumn,
                                "column_value" => $languageValidatedData[$fillableColumn]
                            ];
                        }
                    }
                }
                app(CmsLanguageService::class)->store($languageFillablePayload);
            }
            $response = getResponse($faq->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return Response::json($request->all(), ResponseAlias::HTTP_CREATED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $faq = Faq::findOrFail($id);
        $validatedData = $this->faqService->validator($request)->validate();
        $message = "Faq Update Successfully Done";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        $response = [];
        DB::beginTransaction();
        try {
            $faq = $this->faqService->update($faq, $validatedData);
            if ($isLanguage) {
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->faqService->languageFieldValidator($value, $key)->validate();
                    foreach (Faq::FAQ_LANGUAGE_FILLABLE as $fillableColumn) {
                        if (!empty($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload = [
                                "table_name" => $faq->getTable(),
                                "key_id" => $faq->id,
                                "lang_code" => $key,
                                "column_name" => $fillableColumn,
                                "column_value" => $languageValidatedData[$fillableColumn]
                            ];
                            app(CmsLanguageService::class)->createOrUpdate($languageFillablePayload);
                            CmsLanguageService::languageCacheClearByKey($faq->getTable(), $faq->id, $key, $fillableColumn);
                        }
                    }
                }

            }
            $response = getResponse($faq->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK, $message);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    public function destroy(int $id): JsonResponse
    {
        $faq = Faq::findOrFail($id);
        $faqDestroyStatus = $this->faqService->destroy($faq);
        $message = $faqDestroyStatus ? "Faq successfully deleted" : "Faq is not deleted";
        $response = getResponse($faqDestroyStatus, $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK, $message);
        return Response::json($response, ResponseAlias::HTTP_OK);

    }
}
