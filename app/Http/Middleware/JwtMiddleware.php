<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Auth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function bearerToken()
    {
        $header = $this->header('Authorization', '');
        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }
    }

    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken();

        if (!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'message' => 'Token not provided.',
                'code' => 401
            ], 401);
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            return response()->json([
                'message' => 'Provided token is expired.',
                'code' => 400
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error while decoding token.',
                'code' => 400
            ], 400);
        }
        $user = User::find($credentials->sub->id);
        $request->auth = $user;
        // dd($credentials->sub->uuid);die;
        // Now let's put the user in the request class so that you can grab it from there
        return $next($request);
    }
}
