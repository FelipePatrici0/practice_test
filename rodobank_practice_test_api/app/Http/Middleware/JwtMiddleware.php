<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Tenta autenticar o usuário usando o token JWT
        try {
            // O método parseToken tenta extrair o token da requisição
            $user = JWTAuth::parseToken()->authenticate();

            // Se o usuário não for encontrado, lança uma exceção
            if (!$user) {
                return Response::json(['error' => 'User not found'], 401);
            }
        } catch (TokenExpiredException $e) {
            return Response::json(['error' => 'Token expired'], 401);
        } catch (TokenInvalidException $e) {
            return Response::json(['error' => 'Invalid token'], 401);
        } catch (JWTException $e) {
            return Response::json(['error' => 'Authorization Token not found'], 401);
        }

        // Se tudo estiver certo, continua com a requisição
        return $next($request);
    }
}
