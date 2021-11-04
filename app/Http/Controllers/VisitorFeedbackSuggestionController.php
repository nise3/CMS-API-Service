<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
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

        $this->$visitorFeedbackSuggestionService = $visitorFeedbackSuggestionService;
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
        $response = getResponse($response, $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
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
}
