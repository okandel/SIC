<?php

namespace App\Repositories\ClientReps;


use App\ClientRep;

use App\Repositories\BaseRepository;   
class ClientRepsRepository extends BaseRepository implements ClientRepsRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(ClientRep::Query());
    } 
    public function list($ClientId, $first_name=null, $last_name=null)
    {
        $reps =$this->query();
       
        $reps = $reps->where('ClientId', '=', $ClientId);
        if ($first_name)
        {
            $reps = $reps->where('first_name', 'like', '%'.$first_name.'%');
        }
        if ($last_name)
        {
            $reps = $reps->where('last_name', 'like', '%'.$last_name.'%');
        }

        $reps = $reps->get();
        return $reps;
    }
 
}