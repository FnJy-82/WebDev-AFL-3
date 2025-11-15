<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (auth()->check() && in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => strtolower($request->method()),
                'model_type' => 'Request',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'description' => $request->method() . ' ' . $request->path(),
            ]);
        }

        return $response;;
    }
}
