<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Log;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Extract JWT token from request
        $jwt = $request->bearerToken();

        // Check if token exists
        if (!$jwt) {
            return response()->json([
                'msg' => 'Akses ditolak, token tidak disertakan'
            ], 401);
        }

        try {
            // Decode the JWT token
            $jwtDecoded = JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));

            // Check the role
            if (isset($jwtDecoded->role) && $jwtDecoded->role === 'admin') {
                return $next($request);
            }

            return response()->json([
                'msg' => 'Akses ditolak, token tidak memenuhi'
            ], 401);

        } catch (\Firebase\JWT\ExpiredException $e) {
            return response()->json([
                'msg' => 'Token kedaluwarsa'
            ], 401);

        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            return response()->json([
                'msg' => 'Signature token tidak valid'
            ], 401);

        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Token decode error: ' . $e->getMessage());
            return response()->json([
                'msg' => 'Akses ditolak, token tidak valid'
            ], 401);
        }
    }
}
