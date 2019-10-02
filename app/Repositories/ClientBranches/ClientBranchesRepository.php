<?php

namespace App\Repositories\ClientBranches;

use App\ClientBranch;

use App\Repositories\BaseRepository;  
class ClientBranchesRepository extends BaseRepository  implements ClientBranchesRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(ClientBranch::Query()); 
    }
    public function list($ClientId=null, $display_name=null, $contact_person=null)
    {
        
        $branches =$this->query();
        
        if ($ClientId)
        {
            $branches = $branches->where('ClientId', '=', $ClientId);
        }
        if ($display_name)
        {
            $branches = $branches->where('display_name', 'like', '%'.$display_name.'%');
        }
        if ($contact_person)
        {
            $branches = $branches->where('contact_person', 'like', '%'.$contact_person.'%');
        }

        $branches = $branches->get();
        return $branches;
    } 
}