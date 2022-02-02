<?php

namespace App\Http\Controllers;

use App\Services\NiseDashboardService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class NiseDashboardController extends Controller
{
    public NiseDashboardService $niseDashboardService;
    private Carbon $startTime;

    /**
     * @param NiseDashboardService $niseDashboardService
     */
    public function __construct(NiseDashboardService $niseDashboardService)
    {
        $this->niseDashboardService = $niseDashboardService;
        $this->startTime = Carbon::now();
    }

    public function getDashboardSummery(): JsonResponse
    {
        $response = [
            'data' => $this->niseDashboardService->getStatistics(),
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => "Nise Statistics",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }


}
