<?php

namespace App\Http\Controllers;

use App\Http\Resources\GalleryResource;
use App\Models\BaseModel;
use App\Models\Gallery;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use App\Services\ContentManagementServices\GalleryService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

/**
 * Class GalleryController
 * @package App\Http\Controllers
 */
class GalleryController extends Controller
{

    /**
     * @var GalleryService
     */
    public GalleryService $galleryService;
    /**
     * @var Carbon
     */
    private Carbon $startTime;


    /**
     * GalleryController constructor.
     * @param GalleryService $galleryService
     */
    public function __construct(GalleryService $galleryService)
    {
        $this->startTime = Carbon::now();
        $this->galleryService = $galleryService;
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
        $filter = $this->galleryService->filterValidator($request)->validate();
        $response = GalleryResource::collection($this->galleryService->getAllGalleries($filter))->resource;
        $response = getResponse($response->toArray(), $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function read(int $id): JsonResponse
    {
        $response = new GalleryResource($this->galleryService->getOneGallery($id));
        $response = getResponse($response->toArray(request()), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
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
        $validated = $this->galleryService->validator($request)->validate();
        $message = "Gallery is Successfully added";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        $response = [];
        DB::beginTransaction();

        try {
            $gallery = $this->galleryService->store($validated);
            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->galleryService->languageFieldValidator($value, $key)->validate();
                    $languageFillablePayload[] = [
                        "table_name" => $gallery->getTable(),
                        "key_id" => $gallery->id,
                        "lang_code" => $key,
                        "column_name" => Gallery::LANGUAGE_ATTR_CONTENT_TITLE,
                        "column_value" => $languageValidatedData['content_title']
                    ];
                }
                app(CmsLanguageService::class)->store($languageFillablePayload);
            }
            $response = getResponse($gallery->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
            DB::commit();
        } catch (Throwable $e) {
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
        $gallery = Gallery::findOrFail($id);
        $validated = $this->galleryService->validator($request, $id)->validate();
        $message = "Gallery Update is Successfully Done";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        $response = [];
        DB::beginTransaction();
        try {
            $gallery = $this->galleryService->update($gallery, $validated);
            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->galleryService->languageFieldValidator($value, $key)->validate();
                    $languageFillablePayload= [
                        "table_name" => $gallery->getTable(),
                        "key_id" => $gallery->id,
                        "lang_code" => $key,
                        "column_name" => Gallery::LANGUAGE_ATTR_CONTENT_TITLE,
                        "column_value" => $languageValidatedData['content_title']
                    ];
                }
                app(CmsLanguageService::class)->createOrUpdate($languageFillablePayload);
            }
            $response = getResponse($gallery->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK, $message);
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
     * @return Exception|JsonResponse|Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        $gallery = Gallery::findOrFail($id);
        try {
            $this->galleryService->destroy($gallery);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Gallery deleted successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
