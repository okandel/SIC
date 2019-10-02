<?php

namespace App\Http\Middleware;

use Closure;
use \App\Traits\Response;
use \App\Employee;
use Session;

class EmployeeAuth
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
        $user_employee = $request->session()->get('user_employee');  
        if (!$user_employee) { 
            if ($request->ajax() || $request->wantsJson() )
                return response('Unauthorized', 401);
            else 
                return redirect('/employee/auth/login')->with('returnUrl', $request->url()); 
        }
        return $next($request);
    }

}
