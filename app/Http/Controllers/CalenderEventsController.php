<?php

namespace App\Http\Controllers;

use App\Models\CalenderEvent;
use App\Services\Calender\CalenderEventService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class CalenderEventsController extends Controller
{
    /**
     * @var CalenderEventService
     */
    public CalenderEventService $calenderEventService;
    /**
     * @var Carbon
     */
    private Carbon $startTime;

    /**
     * CalenderEventsController constructor.
     * @param CalenderEventService $calenderEventService
     */
    public function __construct(CalenderEventService $calenderEventService)
    {
        $this->startTime = Carbon::now();
        $this->calenderEventService = $calenderEventService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->calenderEventService->filterValidator($request)->validate();
        $response = $this->calenderEventService->getAllCalenderEvents($filter, $this->startTime);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function read(int $id): JsonResponse
    {
        $calenderEvent = $this->calenderEventService->getOneCalenderEvent($id);

        $response = [
            "data" => $calenderEvent,
            "_response_status" => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException|Throwable
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->calenderEventService->validator($request)->validate();
        $calenderEvent = $this->calenderEventService->store($validated);
        $response = [
            'data' => $calenderEvent,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => "Calender event added successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
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
        $calenderEvent = CalenderEvent::findOrFail($id);
        $validated = $this->calenderEventService->validator($request, $id)->validate();
        $calenderEvent = $this->calenderEventService->update($calenderEvent, $validated);
        $response = [
            'data' => $calenderEvent,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Calender event updated successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        $calenderEvent = CalenderEvent::findOrFail($id);
        $this->calenderEventService->destroy($calenderEvent);
        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Calender Event deleted successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }


}
