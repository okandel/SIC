<?php

namespace App\Http\Middleware;

use Closure;
use App\Auth\Api\v1\Facades\UserAuthentication as Auth;
use Validator;
use Illuminate\Support\Facades\Config; 
use App\Firm;
use App\Repositories\Firms\FirmsRepositoryInterface; 
class UserAuthenticate
{
    use \App\Traits\Response;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $firmsRepositoryInterface;
    public function __construct(FirmsRepositoryInterface $firmsRepositoryInterface)
    { 
        $this->firmsRepositoryInterface = $firmsRepositoryInterface;
    }
    public function handle($request, Closure $next)
    { 

        $headers = [];

        $headers['token'] = $request->header('x-auth-token');
        $headers['userType'] = $request->header('x-user-type'); 
        $headers['langCode'] = $request->header('x-lang-code');


        $domain = $request->getHttpHost();
        $firm =  \CurrentFirm::get();

        //For Admin Dashboard
        if ($request->ajax())
        { 
        }else{
            $validator = Validator::make($headers, [
                'token'=>'string|required',
                "userType'=>'required|in:".Config::get('constants.USER_TYPE_EMPLOYEE').",".Config::get('constants.USER_TYPE_CLIENTREP'),
                'langCode'=>'string'
    
                ]);
    
            if($validator->fails()){
                return self::errify(400, ['validator'=>$validator]);
            } 
            Auth::setRequest($request);
    
            if(!Auth::login())
              return self::errify(401, ['errors'=>['auth.invalid_token']]); 
        } 
        
        return $next($request);
    }
}
