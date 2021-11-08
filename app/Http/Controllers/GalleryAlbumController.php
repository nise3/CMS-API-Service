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
        $request->offsetSet(BaseModel::IS_COLLECTION_KEY, BaseModel::IS_COLLECTION_FLAG);
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
        $response = new GalleryAlbumResource($this->galleryAlbumService->getOneGalleryAlbum($id));
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

        $validatedData = $this->galleryAlbumService->validator($request)->validate();
        $message = "Gallery Album is successfully added";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));

        DB::beginTransaction();
        try {
            $galleryAlbumData = $this->galleryAlbumService->store($validatedData);
            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->galleryAlbumService->languageFieldValidator($value, $key)->validate();
                    foreach (GalleryAlbum::GALLERY_ALBUM_LANGUAGE_FILLABLE as $fillableColumn) {
                        if (isset($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload[] = [
                                "table_name" => $galleryAlbumData->getTable(),
                                "key_id" => $galleryAlbumData->id,
                                "lang_code" => $key,
                                "column_name" => $fillableColumn,
                                "column_value" => $languageValidatedData[$fillableColumn]
                            ];

                        }
                    }
                }
                app(CmsLanguageService::class)->store($languageFillablePayload);
            }
            $response = new GalleryAlbumResource($galleryAlbumData);
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
     * @throws ValidationException|Throwable
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $galleryAlbum = GalleryAlbum::findOrFail($id);
        $validatedData = $this->galleryAlbumService->validator($request, $id)->validate();
        $message = "Gallery Album Update is Successfully Done";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        DB::beginTransaction();
        try {
            $galleryAlbum = $this->galleryAlbumService->update($galleryAlbum, $validatedData);
            if ($isLanguage) {
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->galleryAlbumService->languageFieldValidator($value, $key)->validate();
                    foreach (GalleryAlbum::GALLERY_ALBUM_LANGUAGE_FILLABLE as $fillableColumn) {
                        if (!empty($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload = [
                                "table_name" => $galleryAlbum->getTable(),
                                "key_id" => $galleryAlbum->id,
                                "lang_code" => $key,
                                "column_name" => $fillableColumn,
                                "column_value" => $languageValidatedData[$fillableColumn]
                            ];
                            app(CmsLanguageService::class)->createOrUpdate($languageFillablePayload);
                            CmsLanguageService::languageCacheClearByKey($galleryAlbum->getTable(), $galleryAlbum->id, $key, $fillableColumn);

                        }

                    }
                }
            }
            $response = getResponse($galleryAlbum->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_CREATED, $message);
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
        $galleryAlbum = GalleryAlbum::findOrFail($id);

        $destroyStatus = $this->galleryAlbumService->destroy($galleryAlbum);

        $message = $destroyStatus ? "Gallery Album successfully deleted" : "Gallery Album is not deleted";
        $response = getResponse($destroyStatus, $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK, $message);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
