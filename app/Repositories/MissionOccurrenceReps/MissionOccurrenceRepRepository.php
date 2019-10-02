<?php

namespace App\Repositories\MissionOccurrenceReps;


use App\MissionOccurrenceRep;
use App\Repositories\MissionOccurrences\MissionOccurrencesRepositoryInterface;

use App\Repositories\BaseRepository;   
class MissionOccurrenceRepRepository extends BaseRepository implements MissionOccurrenceRepRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(MissionOccurrenceRep::Query()); 
    }  

    public function list()
    { 
        $reps = $this->getAll(); 
        return $reps;
    } 
}