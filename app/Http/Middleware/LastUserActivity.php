<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\UsersChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LastUserActivity
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
        if (Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(2); /* already given time here we already set 2 min. */
            Cache::put('online' . Auth::user()->id, true, $expiresAt);

            UsersChat::where('user_id', Auth::user()->id)->update(['last_seen'=>Carbon::now()]);
        }
        return $next($request);
    }
}
