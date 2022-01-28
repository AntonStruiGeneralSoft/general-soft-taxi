<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\JWT\TokenService;
use App\Models\User;

class InsertUserRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!is_null($token)) {
            $result = TokenService::isValid($token);
            
            if ($result) {
                $request->merge(['user' => User::find($result->data->id)]);
            }
        }

        return $next($request);
    }
}
