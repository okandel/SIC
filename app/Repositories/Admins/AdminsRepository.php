<?php

namespace App\Repositories\Admins;


use App\Admin;

use App\Repositories\BaseRepository; 
class AdminsRepository extends BaseRepository  implements AdminsRepositoryInterface
{  
    public function __construct(){ 
        parent::__construct(Admin::Query()); 
    }

    public function list()
    {
        $admins = $this->getAll();
        return $admins;
    } 
}