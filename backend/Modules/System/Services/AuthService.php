<?php

namespace Modules\System\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Modules\System\Models\User;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthService
{
    public $request;

    /**
     * Authenticates user into system by ApiToken.
     *
     * @return JsonResponse
     */
    public function authenticate()
    {
        $Credentials = [
            'email' => trim($this->request['data']['email']),
            'password' => trim($this->request['data']['password'])
        ];

        $User = User::where('email', $Credentials['email'])->first();
        if ($User == null) {
            throw new BadRequestHttpException('User not found.');
        }
        if (!Hash::check($Credentials['password'], $User->password)) {
            throw new BadRequestHttpException('Incorrect password.');
        }

        $Token = $User->createToken(env('TOKEN_NAME'))->plainTextToken;
        if (!$Token) {
            throw new BadRequestHttpException('Token failure.');
        }

        $Response['Response'] = [
            'User' => $User,
            'Token' => $Token
        ];

        return response()->json($Response, 200);
    }

    /**
     * Setter for $request variable.
     *
     * @param $request
     * @return AuthService
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }
}
