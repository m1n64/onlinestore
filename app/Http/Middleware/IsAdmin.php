<?php

namespace App\Http\Middleware;

use App\Classes\Constants\StatusCodes;
use App\Enums\StatusCodesEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class IsAdmin
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
        if (!$request->user()?->can("is_admin")) abort(StatusCodes::NOT_ALLOWED);
        return $next($request);
    }
}
