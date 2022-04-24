<?php

namespace App\Http\Controllers;

use App\Models\LocUnion;
use App\Services\LocationManagementServices\LocUnionService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class LocUnionController extends Controller
{
    public LocUnionService $locUnionService;
    public Carbon $startTime;

    public function __construct(LocUnionService $locUnionService, Carbon $startTime)
    {
        $this->locUnionService = $locUnionService;
        $this->startTime = $startTime;
    }


    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->locUnionService->filterValidator($request)->validate();
        $response = $this->locUnionService->getAllUnions($filter, $this->startTime);
        return Response::json($response);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function read(Request $request, int $id): JsonResponse
    {
        $response = $this->locUnionService->getOneUnion($id, $this->startTime);
        if (!$response) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
        return Response::json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws Throwable
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        //$this->authorize('create', LocUnion::class);

        $validated = $this->locUnionService->validator($request)->validate();
        $locUnion = $this->locUnionService->store($validated);
        $response = [
            'data' => $locUnion,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => "Union added successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $locUnion = LocUnion::findOrFail($id);

        //$this->authorize('update', $locUnion);

        $validated = $this->locUnionService->validator($request, $id)->validate();
        $locUnion = $this->locUnionService->update($validated, $locUnion);
        $response = [
            'data' => $locUnion,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Union updated successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        $locUnion = LocUnion::findOrFail($id);

        //$this->authorize('delete', $locUnion);

        $this->locUnionService->destroy($locUnion);
        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Union deleted successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
