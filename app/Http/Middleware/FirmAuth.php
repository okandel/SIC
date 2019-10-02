<?php

namespace App\Http\Middleware;

use Closure;
use \App\Traits\Response;
use \App\Firm;
use Session;

class FirmAuth
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = null)
    {
        $user_firm = $request->session()->get('user_firm');  
        if (!$user_firm) { 
            if ($request->ajax() || $request->wantsJson() )
                return response('Unauthorized', 401);
            else 
                return redirect('/firm/auth/login')->with('returnUrl', $request->url()); 
        }
        return $next($request);
    }

}
