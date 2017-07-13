<?php

namespace CodeFlix\Http\Controllers\Api;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use function response;


class AuthController extends Controller
{
    use AuthenticatesUsers;


    public function accessToken(Request $request)
    {
        $this->validateLogin($request);
        $credentials = $this->credentials($request);

        //se for o token correto ira passar pelo if abaixo
        if($token = \Auth::guard('api')->attempt($credentials)){
            return $this->sendLoginResponse($request, $token);
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request, $token)
    {
//        return response()->json([
//            'token' => $token
//        ]);
        //ou
        return ['token' => $token];
    }

    /**
     * tratamento de erro quando se enviar credenciais invalidas
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json([
            'error' => \Lang::get('auth.failed'),
        ], 400); //bad request
    }

    public function logout(Request $request)
    {
        \Auth::guard('api')->logout();
        return response()->json([], 204);//ok no content
    }
}
