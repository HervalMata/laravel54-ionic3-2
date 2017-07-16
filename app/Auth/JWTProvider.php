<?php

namespace CodeFlix\Auth;

use Dingo\Api\Auth\Provider\Authorization;
use Dingo\Api\Routing\Route;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWT;

class JWTProvider extends Authorization
{
    /**
     * @var JWT
     */
    private $jwt;
    
    /**
     * JWTProvider constructor.
     */
    public function __construct(JWT $jwt)
    {
        $this->jwt = $jwt;
    }


    /**
     * Get the providers authorization method.
     * Obtem no header da requisicao passasse a Authorizatiom = bearer
     * @return string
     */
    public function getAuthorizationMethod()
    {
        return 'bearer';
    }

    /**
     * Authenticate the request and return the authenticated user instance.
     * retorna a instancia do user autenticada
     *
     * @param \Illuminate\Http\Request $request
     * @param \Dingo\Api\Routing\Route $route
     *
     * @return mixed
     */
    public function authenticate(Request $request, Route $route)
    {
        try {
            return \Auth::guard('api')->authenticate();
        } catch (AuthenticationException $exception) {
            $this->refreshToken();
            return \Auth::guard('api')->user();
        }

    }

    private function refreshToken()
    {
        $token = $this->jwt->parseToken()->refresh();
        $this->jwt->setToken($token);
    }
}