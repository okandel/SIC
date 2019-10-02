<?php

namespace App\Repositories\Users;


use App\FirmLogin;
use App\Repositories\BaseRepository;   
class UsersRepository extends BaseRepository implements UsersRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(FirmLogin::Query());
    }  

    public function list($first_name=null,$last_name=null)
    { 
        $users =$this->query();
        if ($first_name)
        {
            $users = $users->where('first_name', 'like', '%'.$first_name.'%');
        }
        if ($last_name)
        {
            $users = $users->where('last_name', 'like', '%'.$last_name.'%');
        }

        $users = $users->get();
        return $users;
    }
 
}