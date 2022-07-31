<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if(!$user->active){
                return response()->json([
                    'response' => [
                        'code' => 1,
                        'msg'  => 'Sin Autorización'
                    ]
                ], 401);
            }

        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json([
                    'response' => [
                        'code' => 2,
                        'msg'  => 'Token inválido'
                    ]
                ], 401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json([
                    'response' => [
                        'code' => 3,
                        'msg'  => 'Token caducado'
                    ]
                ], 401);
            }else{
                return response()->json([
                    'response' => [
                        'code' => 4,
                        'msg'  => 'Autorización no encontrada'
                    ]
                ], 401);
            }
        }
        return $next($request);
    }
}
