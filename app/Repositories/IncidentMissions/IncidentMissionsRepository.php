<?php

namespace App\Repositories\IncidentMissions;

use App\Client;
use App\IncidentMission;

use App\Repositories\BaseRepository;   
class IncidentMissionsRepository extends BaseRepository implements IncidentMissionsRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(IncidentMission::Query()); 
    }   

    public function list(array $param = [])
    //($EmpId=null, $ClientId=null, $ClientBranchId=null)
    {
        $incidentMissions = $this->query();

        $EmpId = $param["EmpId"] ?? null;
        $ClientId = $param["ClientId"] ?? null;
        $ClientBranchId = $param["ClientBranchId"] ?? null;
 
        $country_id = $param["country_id"] ?? null;
        $state_id = $param["state_id"] ?? null;
        $city_id = $param["city_id"] ?? null;

        
        $from_date = $param["from_date"] ?? null;
        $to_date = $param["to_date"] ?? null; 

        if($EmpId)
        {
            if(is_array($EmpId))
            {

                $incidentMissions = $incidentMissions->whereIn('EmpId', $EmpId); 
            }else
            {
                $incidentMissions = $incidentMissions->where('EmpId', '=', $EmpId); 
            }
        }
        if($ClientId && !$ClientBranchId)
        {
            $incidentMissions = $incidentMissions->whereHas('client_branch', function($query) use($ClientId)
            {
                $query->where("ClientId",$ClientId);
            });
        }
        if($ClientBranchId)
        {
            $incidentMissions = $incidentMissions->where('ClientBranchId', '=', $ClientBranchId);
        }

        if($from_date)
        {
            $incidentMissions = $incidentMissions->where('created_at', '>=', $from_date);
        }
        if($to_date)
        {
            $incidentMissions = $incidentMissions->where('created_at', '<=', $to_date);
        }

         //$country_id || $state_id || $city_id
         $incidentMissions = $incidentMissions->when($country_id || $state_id || $city_id
         , function ($query) use($country_id,$state_id,$city_id) {
         
            return $query->when($country_id, function ($query, $country_id) {
                return $query->whereHas('client_branch', function ($query) use($country_id){
                    $query->where('CountryId', $country_id);
                });   
            }) 
            ->when($state_id, function ($query, $state_id) {
                return $query->whereHas('client_branch', function ($query) use($state_id){
                    $query->where('StateId', $state_id);
                }); 
            }) 
            ->when($city_id, function ($query, $city_id) {
                return $query->whereHas('client_branch', function ($query) use($city_id){
                    $query->where('CityId', $city_id);
                });  
            }); 

        });  
        $incidentMissions = $incidentMissions->orderBy('start_date', 'DESC')->get();

        return $incidentMissions;
    } 
 
}