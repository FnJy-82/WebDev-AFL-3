<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
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

        if (Auth::check() && in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            ActivityLog::create([
                'user_id'    => Auth::id(), // Using Auth::id()
                'action'     => strtolower($request->method()),
                'model_type' => 'Request',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'description' => $request->method() . ' ' . $request->path(),
            ]);
        }

        return $response;;
    }
}
