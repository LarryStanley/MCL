<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userGroup = DB::table("users_group")->where("group_name", "admin")->where("user_id", Auth::user()->id)->first();

        if (empty($userGroup)) {
            return redirect("/dashboard");
        }

        return $next($request);
    }
}
