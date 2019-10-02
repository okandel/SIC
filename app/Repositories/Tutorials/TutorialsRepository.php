<?php

namespace App\Repositories\Tutorials;


use App\Repositories\BaseRepository;
use App\Tutorial;

class TutorialsRepository extends BaseRepository implements TutorialsRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(Tutorial::Query());
    }  

    public function list($title=null)
    { 
        $tutorials =$this->query();
        if ($title)
        {
            $tutorials = $tutorials->where('title', 'like', '%'.$title.'%');
        }

        $tutorials = $tutorials->get();
        return $tutorials;
    }
 
}