<?php

namespace App\Http\Middleware;

use App\Models\BaseModel;
use App\Models\User;
use App\Models\Youth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var Auth
     */
    protected Auth $auth;

    /**
     * Create a new middleware instance.
     *
     * @param Auth $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $guard = null)
    {
        if (!Auth::id()) {
            return response()->json([
                "_response_status" => [
                    "success" => false,
                    "code" => ResponseAlias::HTTP_UNAUTHORIZED,
                    "message" => "Unauthenticated action"
                ]
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        } else {
            /** @var User $authUser */
            $authUser = Auth::user();
            if ($authUser instanceof User) { //Backend Users
                if ($authUser->isInstituteUser()) {
                    $request->offsetSet('institute_id', $authUser->institute_id);
                    $request->offsetSet('show_in', BaseModel::SHOW_IN_TSP);
                } else if ($authUser->isOrganizationUser()) {
                    $request->offsetSet('organization_id', $authUser->organization_id);
                    $request->offsetSet('show_in', BaseModel::SHOW_IN_INDUSTRY);
                } else if ($authUser->isIndustryAssociationUser()) {
                    $request->offsetSet('industry_association_id', $authUser->industry_association_id);
                    $request->offsetSet('show_in', BaseModel::SHOW_IN_INDUSTRY_ASSOCIATION);
                }
            } elseif ($authUser instanceof Youth){
                $request->offsetSet('youth_id', $authUser->id);
                $request->offsetSet('show_in', BaseModel::SHOW_IN_YOUTH);
            }
        }

        return $next($request);
    }
}
