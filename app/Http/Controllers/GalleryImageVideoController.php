<?php

namespace App\Http\Controllers;

use App\Http\Resources\GalleryImageVideoResource;
use App\Models\BaseModel;
use App\Models\GalleryImageVideo;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use App\Services\ContentManagementServices\GalleryImageVideoService;
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
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->galleryImageVideoService->filterValidator($request)->validate();
        $response = GalleryImageVideoResource::collection($this->galleryImageVideoService->getGalleryImageVideoList($filter))->resource;
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
        $response = new GalleryImageVideoResource($this->galleryImageVideoService->getOneGalleryImageVideo($id));
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
                    $languageFillablePayload[] = [
                        "table_name" => $galleryImageVideo->getTable(),
                        "key_id" => $galleryImageVideo->id,
                        "lang_code" => $key,
                        "column_name" => GalleryImageVideo::LANGUAGE_ATTR_CONTENT_TITLE,
                        "column_value" => $languageValidatedData['content_title']
                    ];
                    $languageFillablePayload[] = [
                        "table_name" => $galleryImageVideo->getTable(),
                        "key_id" => $galleryImageVideo->id,
                        "lang_code" => $key,
                        "column_name" => GalleryImageVideo::LANGUAGE_ATTR_CONTENT_DESCRIPTION,
                        "column_value" => $languageValidatedData['content_description']
                    ];
                    $languageFillablePayload[] = [
                        "table_name" => $galleryImageVideo->getTable(),
                        "key_id" => $galleryImageVideo->id,
                        "lang_code" => $key,
                        "column_name" => GalleryImageVideo::LANGUAGE_ATTR_ALT_TITLE,
                        "column_value" => $languageValidatedData['alt_title']
                    ];
                }
                app(CmsLanguageService::class)->store($languageFillablePayload);
            }
            $response = getResponse($galleryImageVideo->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
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
        $response = [];
        DB::beginTransaction();
        try {
            $galleryImageVideo = $this->galleryImageVideoService->update($galleryImageVideo, $validatedData);
            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->galleryImageVideoService->languageFieldValidator($value, $key)->validate();
                    $languageFillablePayload = [
                        "table_name" => $galleryImageVideo->getTable(),
                        "key_id" => $galleryImageVideo->id,
                        "lang_code" => $key,
                        "column_name" => GalleryImageVideo::LANGUAGE_ATTR_CONTENT_TITLE,
                        "column_value" => $languageValidatedData['content_title']
                    ];
                }
                app(CmsLanguageService::class)->createOrUpdate($languageFillablePayload);
            }
            $response = getResponse($galleryImageVideo->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK, $message);
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
        $galleryImageVideo = GalleryImageVideo::findOrFail($id);
        $response = getResponse((array)$this->galleryImageVideoService->destroy($galleryImageVideo), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
