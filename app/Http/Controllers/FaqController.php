<?php

namespace App\Http\Controllers;

use App\Http\Resources\FaqResource;
use App\Models\BaseModel;
use App\Models\CmsLanguage;
use App\Models\Faq;
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

class FaqController extends Controller
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
        return Response::json($response);
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
        $faq = app(Faq::class);
        $validatedData = $this->faqService->validator($request)->validate();
        $message = "Faq successfully added";
        $languageFields = $validatedData['language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($languageFields), array_keys(config('languages.others'))));
        $response = [];
        DB::beginTransaction();
        try {
            $faqData = $this->faqService->store($faq, $validatedData);
            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($languageFields as $key => $value) {
                    $languageValidatedData = $this->faqService->languageFieldValidator($value, $key)->validate();
                    $languageFillablePayload[] = [
                        "table_name" => $faq->getTable(),
                        "key_id" => $faqData->id,
                        "lang_code" => $key,
                        "column_name" => Faq::LANGUAGE_ATTR_QUESTION,
                        "column_value" => $languageValidatedData['question']
                    ];

                    $languageFillablePayload[] = [
                        "table_name" => $faq->getTable(),
                        "key_id" => $faqData->id,
                        "lang_code" => $key,
                        "column_name" => Faq::LANGUAGE_ATTR_ANSWER,
                        "column_value" => $languageValidatedData['answer']
                    ];

                }
                app(CmsLanguageService::class)->store($languageFillablePayload);
            }
            $response = getResponse($faqData->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws Throwable
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $faq = Faq::findOrFail($id);
        $validatedData = $this->faqService->validator($request)->validate();
        $message = "Faq successfully added";
        $languageFields = $validatedData['language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($languageFields), array_keys(config('languages.others'))));
        $response = [];
        DB::beginTransaction();
        try {
            $faqData = $this->faqService->update($faq, $validatedData);
            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($languageFields as $key => $value) {
                    $languageValidatedData = $this->faqService->languageFieldValidator($value, $key)->validate();
                    $languageFillablePayload[] = [
                        "table_name" => $faq->getTable(),
                        "key_id" => $faqData->id,
                        "lang_code" => $key,
                        "column_name" => Faq::LANGUAGE_ATTR_QUESTION,
                        "column_value" => $languageValidatedData['question']
                    ];

                    $languageFillablePayload[] = [
                        "table_name" => $faq->getTable(),
                        "key_id" => $faqData->id,
                        "lang_code" => $key,
                        "column_name" => Faq::LANGUAGE_ATTR_ANSWER,
                        "column_value" => $languageValidatedData['answer']
                    ];

                }
                app(CmsLanguageService::class)->store($languageFillablePayload);
            }
            $response = getResponse($faqData->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }


}
