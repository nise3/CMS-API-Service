<?php

namespace App\Http\Controllers;

use App\Http\Resources\FaqResource;
use App\Models\BaseModel;
use App\Models\GalleryCategory;
use App\Services\ContentManagementServices\FaqService;
use App\Services\ContentManagementServices\GalleryCategoryService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\CollectsResources;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class FaqController extends Controller
{
    public FaqService $faqService;
    private Carbon $startTime;

    public function __construct(FaqService $faqService)
    {
        $this->startTime = Carbon::now();
        $this->faqService = $faqService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws Throwable
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->faqService->filterValidator($request)->validate();
        $response = FaqResource::collection($this->faqService->getFaqList($filter))->resource;
        $response = getResponse($response->toArray(), $this->startTime,!BaseModel::IS_SINGLE_RESPONSE);
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
        $response = new FaqResource($this->faqService->getOneFaq($id));
        $response = getResponse($response->toArray($request), $this->startTime,BaseModel::IS_SINGLE_RESPONSE);
        return Response::json($response);
    }


}
