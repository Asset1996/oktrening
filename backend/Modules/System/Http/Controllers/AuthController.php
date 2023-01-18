<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Modules\System\Services\AuthService;

class AuthController extends BaseController
{
    /**
     * Authenticates user into system by ApiToken.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function authenticate(Request $request): JsonResponse
    {
        return (new AuthService)
            ->setRequest($request)
            ->authenticate();
    }
}
