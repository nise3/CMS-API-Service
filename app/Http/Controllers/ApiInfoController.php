<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ApiInfoController extends Controller
{
    const SERVICE_NAME = 'NISE-3 CMS Api Service';
    const SERVICE_VERSION = 'V1';

    public function apiInfo(): JsonResponse
    {
        $response = [
            'service_name' => self::SERVICE_NAME,
            'service_version' => self::SERVICE_VERSION,
            'lumen_version' => App::version(),
            'modules' => [
                'CMSManagement' => [
                ]
            ],
            'description' => 'It a cms api service that manages cms'

        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
