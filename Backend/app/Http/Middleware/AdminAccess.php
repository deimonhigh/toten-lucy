<?php

namespace App\Http\Middleware;

use App\Gate;
use Closure;

class AdminAccess
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if (Gate::access($request->route())) {
      return redirect(route('home'));
    } else {
      return $next($request);
    }
  }
}
