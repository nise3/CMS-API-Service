<?php

namespace App\Http\Controllers;

use App\Http\Resources\Nise3PartnerResource;
use App\Models\BaseModel;
use App\Models\Nise3Partner;
use App\Services\Common\LanguageCodeService;
use App\Services\ContentManagementServices\CmsLanguageService;
use App\Services\ContentManagementServices\Nise3PartnerService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class Nise3PartnerController extends Controller
{
    public Nise3PartnerService $nise3PartnerService;

    private Carbon $startTime;

    public function __construct(Nise3PartnerService $nise3PartnerService)
    {
        $this->startTime = Carbon::now();
        $this->nise3PartnerService = $nise3PartnerService;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->nise3PartnerService->filterValidation($request)->validate();
        $response = Nise3PartnerResource::collection($this->nise3PartnerService->getPartnerList($filter))->resource;
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
        $response = new Nise3PartnerResource($this->nise3PartnerService->getOnePartner($id));
        $response = getResponse($response->toArray($request), $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
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
        $response = new Nise3PartnerResource($this->nise3PartnerService->getOnePartner($id));
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
        $validatedData = $this->nise3PartnerService->validator($request)->validate();
        $message = "Nise3 Partner successfully added";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        DB::beginTransaction();
        try {
            $nise3Partner = $this->nise3PartnerService->store($validatedData);
            if ($isLanguage) {
                $languageFillablePayload = [];
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->nise3PartnerService->languageFieldValidator($value, $key)->validate();
                    foreach (Nise3Partner::NISE_3_PARTNER_LANGUAGE_FIELDS as $fillableColumn) {
                        if (isset($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload[] = [
                                "table_name" => $nise3Partner->getTable(),
                                "key_id" => $nise3Partner->id,
                                "lang_code" => $key,
                                "column_name" => $fillableColumn,
                                "column_value" => $languageValidatedData[$fillableColumn]
                            ];
                        }
                    }

                }
                app(CmsLanguageService::class)->store($languageFillablePayload);
            }
            $response = new Nise3PartnerResource($nise3Partner);
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
        $nise3Partner = Nise3Partner::findOrFail($id);
        $validatedData = $this->nise3PartnerService->validator($request)->validate();
        $message = "Nise3Partner Update Successfully Done";
        $otherLanguagePayload = $validatedData['other_language_fields'] ?? [];
        $isLanguage = (bool)count(array_intersect(array_keys($otherLanguagePayload), LanguageCodeService::getLanguageCode()));
        DB::beginTransaction();
        try {
            $nise3Partner = $this->nise3PartnerService->update($nise3Partner, $validatedData);
            if ($isLanguage) {
                foreach ($otherLanguagePayload as $key => $value) {
                    $languageValidatedData = $this->nise3PartnerService->languageFieldValidator($value, $key)->validate();
                    foreach (Nise3Partner::NISE_3_PARTNER_LANGUAGE_FIELDS as $fillableColumn) {
                        if (isset($languageValidatedData[$fillableColumn])) {
                            $languageFillablePayload = [
                                "table_name" => $nise3Partner->getTable(),
                                "key_id" => $nise3Partner->id,
                                "lang_code" => $key,
                                "column_name" => $fillableColumn,
                                "column_value" => $languageValidatedData[$fillableColumn]
                            ];
                            app(CmsLanguageService::class)->createOrUpdate($languageFillablePayload);
                        }
                    }
                }
            }
            $response = new Nise3PartnerResource($nise3Partner);
            $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK, $message);
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
        $partner = Nise3Partner::findOrFail($id);
        $deleteStatus = $this->nise3PartnerService->destroy($partner);
        $message = $deleteStatus ? "Nise3Partner successfully deleted" : "Nise3Partner is not deleted";
        $response = getResponse($deleteStatus, $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK, $message);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

}
