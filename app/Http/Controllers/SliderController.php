<?php

namespace App\Http\Controllers;

use App\Http\Resources\FaqResource;
use App\Http\Resources\SliderResource;
use App\Models\BaseModel;
use App\Models\Slider;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use App\Services\ContentManagementServices\SliderService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;
use Exception;

class SliderController extends Controller
{
    public SliderService $sliderService;
    private Carbon $startTime;


    public function __construct(SliderService $sliderService)
    {
        $this->startTime = Carbon::now();
        $this->sliderService = $sliderService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->sliderService->filterValidator($request)->validate();
        $message="Slider list";
        $response = SliderResource::collection($this->sliderService->getAllSliders($filter))->resource;
        $response = getResponse($response->toArray(), $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK,$message);
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
        $message="Slider details";
        $response = new SliderResource($this->sliderService->getOneSlider($id));
        $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK,$message);
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
        $validatedData = $this->sliderService->validator($request)->validate();
        $message = "Slider successfully added";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        $response = [];
        DB::beginTransaction();
        try {
            $slider = $this->sliderService->store($validatedData);
            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->sliderService->languageFieldValidator($value, $key)->validate();
                    foreach (Slider::SLIDER_LANGUAGE_FIELDS as $fillableColumn){
                        if (!empty($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload[] = [
                                "table_name" => $slider->getTable(),
                                "key_id" => $slider->id,
                                "lang_code" => $key,
                                "column_name" => $fillableColumn,
                                "column_value" => $languageValidatedData[$fillableColumn]
                            ];
                        }
                    }
                }
                app(CmsLanguageService::class)->store($languageFillablePayload);
            }
            $response=new SliderResource($slider);
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
        $slider = Slider::findOrFail($id);
        $validatedData = $this->sliderService->validator($request)->validate();
        $message = "Slider successfully update";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        $response = [];
        DB::beginTransaction();
        try {
            $slider = $this->sliderService->update($slider, $validatedData);
            if ($isLanguage) {
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->sliderService->languageFieldValidator($value, $key)->validate();
                    foreach (Slider::SLIDER_LANGUAGE_FIELDS as $fillableColumn){
                        if (!empty($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload = [
                                "table_name" => $slider->getTable(),
                                "key_id" => $slider->id,
                                "lang_code" => $key,
                                "column_name" => $fillableColumn,
                                "column_value" => $languageValidatedData[$fillableColumn]
                            ];
                            app(CmsLanguageService::class)->createOrUpdate($languageFillablePayload);
                        }
                    }
                }
            }
            $response=new SliderResource($slider);
            $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
            DB::commit();

        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $slider = Slider::findOrFail($id);
        $destroyStatus = $this->sliderService->destroy($slider);
        $message = $destroyStatus ? "Slider successfully deleted" : "Slider is not deleted";
        $response = getResponse($destroyStatus, $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK, $message);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
