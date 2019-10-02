<?php

namespace App\Http\Middleware;

use Closure;
use App\Auth\Api\v1\Facades\UserAuthentication as Auth;
use Validator;
use Illuminate\Support\Facades\Config; 
use App\Firm;
use App\Repositories\Firms\FirmsRepositoryInterface; 
class ValidFirm
{
    use \App\Traits\Response;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */ 
    public function __construct()
    {  
    }
    public function handle($request, Closure $next)
    { 
        
        $firm =  \CurrentFirm::get();
         if ($firm== null)
         { 
            if( $request->header('x-auth-token')|| $request->is('api/*'))
            { 
                return self::errify(400, ['errors' => ['firm.not_found' ]]); 
            }else
            {
                if($request->ajax()){
                    return self::errify(400, ['errors' => ['firm.not_found' ]]);
                }else
                {
                    return abort(404, 'firm.not_found'); 
                }
            }  
         } 
        return $next($request);
    }
}
