<?php

namespace App\Http\Controllers;

use App\Models\Nise3Partner;
use App\Services\ContentManagementServices\Nise3PartnerService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->nise3PartnerService->filterValidation($request)->validate();
        try {
            $response = $this->nise3PartnerService->getPartnerList($filter, $this->startTime);
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Exception|JsonResponse|Throwable
     */
    public function read(Request $request,int $id):JsonResponse
    {
        try {
            $response = $this->nise3PartnerService->getOnePartner($id, $this->startTime);
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response);
    }


    /**
     * @param Request $request
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $partner = new Nise3Partner();
        $validated = $this->nise3PartnerService->validator($request)->validate();
        try {
            $partner = $this->nise3PartnerService->store($partner, $validated);
            $response = [
                'data' => $partner,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "Partner is added successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now())
                ]
            ];
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
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $partner = Nise3Partner::findOrFail($id);
        $validated = $this->nise3PartnerService->validator($request, $id)->validate();
        try {
            $partner = $this->nise3PartnerService->update($partner, $validated);
            $response = [
                'data' => $partner,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Partner Item is updated successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Exception|JsonResponse|Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        $partner = Nise3Partner::findOrFail($id);
        try {
            $this->nise3PartnerService->destroy($partner);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Partner deleted successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

}
