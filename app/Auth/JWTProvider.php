<?php
/**
 * Created by PhpStorm.
 * User: carlosanders
 * Date: 12/07/17
 * Time: 21:42
 */

namespace CodeFlix\Auth;

use Dingo\Api\Auth\Provider\Authorization;
use Dingo\Api\Routing\Route;
use Illuminate\Http\Request;

class JWTProvider extends Authorization
{

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
        return \Auth::guard('api')->authenticate();
    }
}