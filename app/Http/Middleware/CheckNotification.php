<?php

namespace App\Http\Middleware;

use Closure;

class CheckNotification
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->exists('notification_read')) {
            $notification = $request->user()->notifications()->where('id', $request->notification_read)->first();
            if ($notification != null)
                $notification->markAsRead();
        }
        return $next($request);
    }
}
