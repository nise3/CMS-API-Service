<?php

namespace App\Http\Controllers;

use App\Models\Publication;

use App\Services\ContentManagementServices\PublicationService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class PublicationController extends Controller
{
    /**
     * @var PublicationService
     */
    public PublicationService $publicationService;

    /**
     * @var Carbon
     */
    private Carbon $startTime;

    /**
     * PublicationController constructor.
     * @param PublicationService $publicationService
     */
    public function __construct(PublicationService $publicationService)
    {
        $this->startTime = Carbon::now();
        $this->publicationService = $publicationService;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException|AuthorizationException
     */

    public function getList(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Publication::class);
        $filter = $this->publicationService->filterValidator($request)->validate();
        $returnedData = $this->publicationService->getPublicationList($filter, $this->startTime);

        $response = [
            'order' => $returnedData['order'],
            'data' => $returnedData['data'],
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                'query_time' => $returnedData['query_time']
            ]
        ];
        if (isset($returnedData['total_page'])) {
            $response['total'] = $returnedData['total'];
            $response['current_page'] = $returnedData['current_page'];
            $response['total_page'] = $returnedData['total_page'];
            $response['page_size'] = $returnedData['page_size'];
        }
        return Response::json($response, ResponseAlias::HTTP_OK);

    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function read(int $id): JsonResponse
    {

        $publication = $this->publicationService->getOnePublication($id);
        $this->authorize('view', $publication);

        $response = [
            "data" => $publication,
            "_response_status" => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function clientSideRead(int $id): JsonResponse
    {

        $publication = $this->publicationService->getOnePublication($id);
        $response = [
            "data" => $publication,
            "_response_status" => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException|AuthorizationException
     */
    function store(Request $request): JsonResponse
    {
        $this->authorize('create', Publication::class);

        $validated = $this->publicationService->validator($request)->validate();
        $data = $this->publicationService->store($validated);
        $response = [
            'data' => $data,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => "publication added successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException|AuthorizationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $publication = Publication::findOrFail($id);
        $this->authorize('update', $publication);

        $validated = $this->publicationService->validator($request, $id)->validate();

        $data = $this->publicationService->update($publication, $validated);
        $response = [
            'data' => $data,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Publication updated successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }


    /**
     * Remove the specified resource from storage
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        $publication = Publication::findOrFail($id);
        $this->authorize('delete', $publication);


        $this->publicationService->destroy($publication);
        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "publication deleted successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Restore the specified  soft deleted resource
     * @param int $id
     * @return JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        $publication = Publication::onlyTrashed()->findOrFail($id);
        $this->publicationService->restore($publication);
        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "publication restored successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    public function getPublicPublicationList(Request $request): JsonResponse
    {

        $filter = $this->publicationService->filterValidator($request)->validate();
        $returnedData = $this->publicationService->getPublicationList($filter, $this->startTime);

        $response = [
            'order' => $returnedData['order'],
            'data' => $returnedData['data'],
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                'query_time' => $returnedData['query_time']
            ]
        ];
        if (isset($returnedData['total_page'])) {
            $response['total'] = $returnedData['total'];
            $response['current_page'] = $returnedData['current_page'];
            $response['total_page'] = $returnedData['total_page'];
            $response['page_size'] = $returnedData['page_size'];
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

}
