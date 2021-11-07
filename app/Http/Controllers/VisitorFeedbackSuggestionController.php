<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\VisitorFeedbackSuggestion;
use App\Services\ContentManagementServices\VisitorFeedbackSuggestionService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Illuminate\Validation\ValidationException;
use Throwable;

class VisitorFeedbackSuggestionController extends Controller
{
    /**
     * @var VisitorFeedbackSuggestionService
     */
    public VisitorFeedbackSuggestionService $visitorFeedbackSuggestionService;
    private Carbon $startTime;


    public function __construct(VisitorFeedbackSuggestionService $visitorFeedbackSuggestionService)
    {
        $this->startTime = Carbon::now();

        $this->visitorFeedbackSuggestionService = $visitorFeedbackSuggestionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->visitorFeedbackSuggestionService->filterValidator($request)->validate();
        $response = $this->visitorFeedbackSuggestionService->getVisitorFeedbackSuggestionList($filter);
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
        $response = $this->visitorFeedbackSuggestionService->getOneVisitorFeedbackSuggestion($id);
        $response = getResponse($response->toArray(), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);

        return Response::json($response, ResponseAlias::HTTP_OK);
    }


    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws ValidationException
     */
    function store(Request $request): JsonResponse
    {
        $this->authorize('create', VisitorFeedbackSuggestion::class);

        $validated = $this->visitorFeedbackSuggestionService->validator($request)->validate();
        $data = $this->visitorFeedbackSuggestionService->store($validated);
        $response = [
            'data' => $data ?: null,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => "Occupation added successfully.",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }



    public function destroy(int $id): JsonResponse
    {
        $occupation = VisitorFeedbackSuggestion::findOrFail($id);
        $this->authorize('delete', $occupation);
        $this->visitorFeedbackSuggestionService->destroy($occupation);
        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Occupation deleted successfully.",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }


}
