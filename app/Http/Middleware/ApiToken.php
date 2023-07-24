<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');
        
        if ($apiKey != '@Takemor.') {
            return response('Unauthorized.', 401);
        }
        
        return $next($request);
    }
}