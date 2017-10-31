<?php

namespace wizpt\cms\Middleware;

use App;
use Closure;
use Session;

class setLang
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
        /**
         * Set App:locale into User Session
         */
        if(!Session::get('locale')) {
            Session::put('locale',App::getLocale());
        }
        return $next($request);
    }
}
