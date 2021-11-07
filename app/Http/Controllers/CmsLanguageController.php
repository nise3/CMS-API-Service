<?php

namespace App\Http\Controllers;

use App\Http\CustomInterfaces\Contract\ResourceInterface;
use App\Models\BaseModel;
use App\Services\ContentManagementServices\CmsLanguageService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CmsLanguageController extends Controller
{
    public CmsLanguageService $cmsLanguageService;
    private Carbon $startTime;

    /**
     * @param CmsLanguageService $cmsLanguageService
     */
    public function __construct(CmsLanguageService $cmsLanguageService)
    {
        $this->cmsLanguageService = $cmsLanguageService;
        $this->startTime = Carbon::now();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function deleteLanguageFieldByKeyId(Request $request): JsonResponse
    {
        $validatedData = $this->cmsLanguageService->languageFieldDeleteValidator($request)->validate();
        $cmsLanguageDestroyStatus = $this->cmsLanguageService->deleteLanguage($validatedData);
        $message = $cmsLanguageDestroyStatus ? "The language field  is  successfully deleted" : "The language field is  not deleted";
        $response = getResponse([], $this->startTime, BaseModel::IS_SINGLE_RESPONSE, ResponseAlias::HTTP_OK, $message);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

}
