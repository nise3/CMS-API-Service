<?php

namespace App\Helpers\Classes;

use App\Models\BaseModel;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ServiceToServiceCallHandler
{

    /**
     * @param string $idpUserId
     * @return mixed
     * @throws RequestException
     */
    public function getAuthUserWithRolePermission(string $idpUserId): mixed
    {
        $url = clientUrl(BaseModel::CORE_CLIENT_URL_TYPE) . 'auth-user-info';
        $userPostField = [
            "idp_user_id" => $idpUserId
        ];

        $responseData = Http::withOptions([
            'verify' => config('nise3.should_ssl_verify'),
            'debug' => config('nise3.http_debug'),
            'timeout' => config('nise3.http_timeout'),
        ])
            ->post($url, $userPostField)
            ->throw(function ($response, $e) use ($url) {
                Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . json_encode($response));
                throw $e;
            })
            ->json('data');

        Log::info("userInfo:" . json_encode($responseData));

        return $responseData;
    }

    /**
     * @param string $idpUserId
     * @return mixed
     * @throws RequestException
     */
    public function getAuthYouthUser(string $idpUserId): mixed
    {
        $url = clientUrl(BaseModel::YOUTH_CLIENT_URL_TYPE) . 'auth-youth-info';
        $userPostField = [
            "idp_user_id" => $idpUserId
        ];

        $responseData = Http::withOptions([
            'verify' => config('nise3.should_ssl_verify'),
            'debug' => config('nise3.http_debug'),
            'timeout' => config('nise3.http_timeout'),
        ])
            ->post($url, $userPostField)
            ->throw(function ($response, $e) use ($url) {
                Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . json_encode($response));
                throw $e;
            })
            ->json('data');

        Log::info("userInfo:" . json_encode($responseData));

        return $responseData;
    }


    /**
     * @param string $url
     * @return mixed
     * @throws RequestException
     */
    public function getNiseDashBoardData(string $url): mixed
    {
        $responseData = Http::withOptions([
            'verify' => config('nise3.should_ssl_verify'),
            'debug' => config('nise3.http_debug'),
            'timeout' => config('nise3.http_timeout'),
        ])
            ->get($url)
            ->throw(function ($response, $e) use ($url) {
                Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . json_encode($response));
                throw $e;
            })
            ->json('data');

        Log::info("Nise3Dashboard:" . json_encode($responseData));

        return $responseData;
    }

}
