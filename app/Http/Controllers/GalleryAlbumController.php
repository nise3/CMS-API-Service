<?php

namespace App\Http\Controllers;

use App\Http\Resources\GalleryAlbumResource;
use App\Models\BaseModel;
use App\Models\GalleryAlbum;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use App\Services\ContentManagementServices\GalleryAlbumService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class GalleryAlbumController extends Controller
{


    public GalleryAlbumService $galleryAlbumService;
    private Carbon $startTime;


    public function __construct(GalleryAlbumService $galleryAlbumService)
    {
        $this->startTime = Carbon::now();
        $this->galleryAlbumService = $galleryAlbumService;
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
        $filter = $this->galleryAlbumService->filterValidator($request)->validate();
        $response = GalleryAlbumResource::collection($this->galleryAlbumService->getAllGalleryAlbums($filter))->resource;
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
        $response = new GalleryAlbumResource($this->galleryAlbumService->getOneGalleryAlbum($id));
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

        $validatedData = $this->galleryAlbumService->validator($request)->validate();
        $message = "Gallery Album successfully added";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));

        DB::beginTransaction();
        try {
            $galleryAlbumData = $this->galleryAlbumService->store($validatedData);
            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->galleryAlbumService->languageFieldValidator($value, $key)->validate();
                    $languageFillablePayload[] = [
                        "table_name" => $galleryAlbumData->getTable(),
                        "key_id" => $galleryAlbumData->id,
                        "lang_code" => $key,
                        "column_name" => GalleryAlbum::LANGUAGE_ATTR_title,
                        "column_value" => $languageValidatedData['title']
                    ];

                    $languageFillablePayload[] = [
                        "table_name" => $galleryAlbumData->getTable(),
                        "key_id" => $galleryAlbumData->id,
                        "lang_code" => $key,
                        "column_name" => GalleryAlbum::LANGUAGE_ATTR_IMAGE_ALT_TITLE,
                        "column_value" => $languageValidatedData['image_alt_title']
                    ];

                }
                app(CmsLanguageService::class)->store($languageFillablePayload);
            }
            $response = getResponse($galleryAlbumData->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
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
     * @throws ValidationException|Throwable
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $galleryAlbum = GalleryAlbum::findOrFail($id);
        $validatedData = $this->galleryAlbumService->validator($request, $id)->validate();
        $message = "Gallery Album Update Successfully Done";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        $response = [];
        DB::beginTransaction();
        try {
            $galleryAlbum = $this->galleryAlbumService->update($galleryAlbum, $validatedData);
            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->galleryAlbumService->languageFieldValidator($value, $key)->validate();
                    $languageFillablePayload[] = [
                        "table_name" => $galleryAlbum->getTable(),
                        "key_id" => $galleryAlbum->id,
                        "lang_code" => $key,
                        "column_name" => GalleryAlbum::LANGUAGE_ATTR_title,
                        "column_value" => $languageValidatedData['question']
                    ];

                    $languageFillablePayload[] = [
                        "table_name" => $galleryAlbum->getTable(),
                        "key_id" => $galleryAlbum->id,
                        "lang_code" => $key,
                        "column_name" => GalleryAlbum::LANGUAGE_ATTR_IMAGE_ALT_TITLE,
                        "column_value" => $languageValidatedData['answer']
                    ];

                }
                app(CmsLanguageService::class)->store($languageFillablePayload);
            }
            $response = getResponse($galleryAlbum->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
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
        $galleryCategory = GalleryAlbum::findOrFail($id);

        $this->galleryAlbumService->destroy($galleryCategory);
        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "GalleryAlbum deleted successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];

        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
