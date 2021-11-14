<?php

namespace App\Http\Controllers;

use App\Http\Resources\SliderResource;
use App\Models\BaseModel;
use App\Models\Slider;
use App\Services\Common\CmsGlobalConfigService;
use App\Services\ContentManagementServices\SliderService;
use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class SliderController extends Controller
{

    public SliderService $sliderService;
    private Carbon $startTime;


    public function __construct(SliderService $sliderService)
    {
        $this->startTime = Carbon::now();
        $this->sliderService = $sliderService;
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
        $filter = $this->sliderService->filterValidator($request)->validate();
        $sliderList = $this->sliderService->getSliderList($filter);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($sliderList->toArray()['data'] ?? $sliderList->toArray()));
        $response = SliderResource::collection($sliderList)->resource;
        $response = getResponse($response->toArray(), $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws RequestException
     */
    public function read(Request $request, int $id): JsonResponse
    {
        $sliderList = $this->sliderService->getOneSlider($id);
        $response = new  SliderResource($sliderList);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($sliderList->toArray()));
        $response = getResponse($response->toArray($request), $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }


    /**
     * @throws RequestException
     * @throws ValidationException
     */
    public function clientSideGetList(Request $request): JsonResponse
    {
        $request->offsetSet(BaseModel::IS_CLIENT_SITE_RESPONSE_KEY, BaseModel::IS_CLIENT_SITE_RESPONSE_FLAG);
        $filter = $this->sliderService->filterValidator($request)->validate();
        $filter[BaseModel::IS_CLIENT_SITE_RESPONSE_KEY] = BaseModel::IS_CLIENT_SITE_RESPONSE_FLAG;
        $sliderList = $this->sliderService->getSliderList($filter, $this->startTime);
        $request->offsetSet(BaseModel::INSTITUTE_ORGANIZATION_INDUSTRY_ASSOCIATION_TITLE_BY_ID, CmsGlobalConfigService::getOrganizationOrInstituteOrIndustryAssociationTitle($sliderList->toArray()['data'] ?? $sliderList->toArray()));
        $response = SliderResource::collection($sliderList)->resource;
        $response = getResponse($response->toArray(), $this->startTime, !BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @throws ValidationException
     */
    function store(Request $request): JsonResponse
    {
        $validated = $this->sliderService->validator($request)->validate();
        $data = $this->sliderService->store($validated);
        $response = [
            'data' => $data ?: null,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => "Slider added successfully.",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }


    /**
     * @throws ValidationException
     */
    function update(Request $request, int $id): JsonResponse
    {
        $slider = Slider::findOrFail($id);
        $validated = $this->sliderService->validator($request, $id)->validate();
        $data = $this->sliderService->update($slider, $validated);
        $response = [
            'data' => $data ?: null,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => "Slider added successfully.",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }


    public function destroy(int $id): JsonResponse
    {
        $visitorFeedback = Slider::findOrFail($id);
        $this->sliderService->destroy($visitorFeedback);
        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Slider deleted successfully.",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

}
