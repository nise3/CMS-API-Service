<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class AuthUser
 * @package App\Facade
 * @method static array|mixed getAuthUserWithRolePermission(string $idpUserId)
 * @method static array|mixed getAuthYouthUser(string $idpUserId)
 * @method static array|mixed getNiseDashBoardData(string $url)
 *
 *
 * @see \App\Helpers\Classes\ServiceToServiceCallHandler
 */
class ServiceToServiceCall extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'service_to_service_call';
    }
}
