<?php

namespace App\Repositories\Missions;

use App\Vehicle;
use App\Client;
use App\ClientBranch;
use App\Mission;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
class MissionsRepository extends BaseRepository implements MissionsRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Mission::Query());
    }

    public function list(array $param = [])
        //($EmpId=null, $ClientId=null, $ClientBranchId=null)
    {
        $missions = $this->query()->where('start_date', '!=', null);

        $EmpId = $param["EmpId"] ?? null;
        $AssignedBy = $param["AssignedBy"] ?? null;
        $ClientId = $param["ClientId"] ?? null;
        $ClientBranchId = $param["ClientBranchId"] ?? null;

        $country_id = $param["country_id"] ?? null;
        $state_id = $param["state_id"] ?? null;
        $city_id = $param["city_id"] ?? null;


        $from_date = $param["from_date"] ?? null;
        $to_date = $param["to_date"] ?? null;

        $ItemId = $param["ItemId"] ?? null;
        $StatusId = $param["StatusId"] ?? null;

        $nearestEmployeeIds =  $param["nearestEmployeeIds"] ?? null;
        $nearestClientIds =  $param["nearestClientIds"] ?? null;
        $nearestVehicleIds =  $param["nearestVehicleIds"] ?? null;


        if ($EmpId) {
            if (is_array($EmpId)) {

                $missions = $missions->whereIn('EmpId', $EmpId);
            } else {
                $missions = $missions->where('EmpId', '=', $EmpId);
            }
        }
        if ($AssignedBy) {
            if (is_array($AssignedBy)) {

                $missions = $missions->whereIn('AssignedBy', $AssignedBy);
            } else {
                $missions = $missions->where('AssignedBy', '=', $AssignedBy);
            }
        }
        if ($ClientId && !$ClientBranchId) {
            $missions = $missions->whereHas('client_branch', function ($query) use ($ClientId) {
                $query->where("ClientId", $ClientId);
            });
        }
        if ($ClientBranchId) {
            $missions = $missions->where('ClientBranchId', '=', $ClientBranchId);
        }

        if ($from_date) {
            $missions = $missions->where('start_date', '>=', $from_date);
        }
        if ($to_date) {
            $missions = $missions->where('start_date', '<=', $to_date);
        }


        //$StatusId
        if ($StatusId) {
            if ($StatusId == 3 || $StatusId == 5) { // completed & re-arranged
                $missions = $missions->where('StatusId', '=', $StatusId);
            } elseif ($StatusId == 1) { // New
                $missions = $missions->where('start_date', '>', Carbon::today()->addDays(1)->addMillis(-1));
            } elseif ($StatusId == 2) { // Pending
                $missions = $missions
                    ->where('start_date', '>=', Carbon::today())
                    ->where('start_date', '<=', Carbon::today()->addDays(1)->addMillis(-1))
                    ->whereNotIn('StatusId',[3,5]);
            } elseif ($StatusId == 4) { // Expired
                $missions = $missions
                    ->where([
                        ['start_date', '<', Carbon::today()],
//                        ['StatusId', '!=', 2],
//                        ['StatusId', '!=', 3],
//                        ['StatusId', '!=', 5],
                    ]);
            }
        }


        //$ItemId
        $missions = $missions->when($ItemId, function ($query) use ($ItemId) {

            return $query->whereHas('tasks', function ($query) use ($ItemId) {
                $query->when($ItemId, function ($query, $item_id) {
                    return $query->where('ItemId', $item_id);
                });
            });
        });

         //$country_id || $state_id || $city_id
         $missions = $missions->when($country_id || $state_id || $city_id
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

        $filtered_missions =clone $missions;

        //$nearestClientIds
        $clientLocations = ClientBranch::Query()
        ->whereHas('client', function ($query) use($nearestClientIds){
              $query->where('id', $nearestClientIds);
           })->select('location as location1');


        $missions = $missions->when($nearestClientIds, function ($query) use($clientLocations,$nearestClientIds) {

             $query->whereHas('client_branch', function($query) use($clientLocations,$nearestClientIds)
            {
                $query->where('ClientId','!=',  $nearestClientIds)
                ->joinSub($clientLocations, 'clientLocations', function ($join) {
                    //$join->on('.id', '=', '.user_id');
                })->whereRaw(DB::raw('(
                    GLength(
                      LineStringFromWKB(
                        LineString(
                            clientLocations.location1,
                            location
                        )
                      )
                    )
                  ) <=1'))
                  ;
            });
        });


        //$nearestVehicleIds
        $missions = $missions->when($nearestVehicleIds, function ($query) use($filtered_missions,$nearestVehicleIds) {
            $vehicleLocations =  $filtered_missions
            ->whereHas('vehicles', function($query) use($nearestVehicleIds)
            {
               return $query->whereIn('VehicleId', $nearestVehicleIds);
            })
            ->join('client_branches', 'client_branches.id', '=', 'missions.ClientBranchId')
            ->select(\DB::raw('X(client_branches.location) as lat'),\DB::raw('Y(client_branches.location) as lng'));
            //->select(\DB::raw('client_branches.location as location12'));

            $query->whereHas('client_branch', function($query) use($vehicleLocations,$nearestVehicleIds)
           {
               $query//->where('ClientId','!=',  $nearestVehicleIds)
               ->joinSub($vehicleLocations, 'vehicleLocations', function ($join) {
                   //$join->on('.id', '=', '.user_id');
               })->whereRaw(DB::raw('(
                   GLength(
                     LineStringFromWKB(
                       LineString(
                        Point(vehicleLocations.lat,vehicleLocations.lng),
                           location
                       )
                     )
                   )
                 ) <=1'))
                 ;
           });
       });





          $missions = $missions->when($nearestEmployeeIds, function ($query) use($filtered_missions,$nearestEmployeeIds) {

            $employeeLocations =  $filtered_missions->whereIn('EmpId', $nearestEmployeeIds)
            ->join('client_branches', 'client_branches.id', '=', 'missions.ClientBranchId')
            ->select(\DB::raw('X(client_branches.location) as lat'),\DB::raw('Y(client_branches.location) as lng'));
            //->select(\DB::raw('client_branches.location as location12'));


               $query->whereHas('client_branch', function($query) use($employeeLocations,$nearestEmployeeIds)
              {
                  $query->whereNotIn('EmpId', $nearestEmployeeIds)
                  ->joinSub($employeeLocations, 'employeeLocations', function ($join) {
                      //$join->on('.id', '=', '.user_id');
                  })->whereRaw(DB::raw('(
                      GLength(
                        LineStringFromWKB(
                          LineString(
                            Point(employeeLocations.lat,employeeLocations.lng),
                              location
                          )
                        )
                      )
                    ) <=1'))
                    ;
              });
          });
        // //$nearestVehicleIds
        // $missions = $missions->when($nearestVehicleIds, function ($query) use($item_id) {

        //     return $query->whereHas('tasks', function($query) use($item_id)
        //     {
        //         $query->when($item_id, function ($query, $item_id) {
        //             return $query->where('ItemId', $item_id);
        //         });
        //     });
        // });

        $missions = $missions->orderBy('start_date', 'DESC')->get();

        return $missions;
    }



    public function listOccurance(array $param = [])
    //($EmpId=null, $ClientId=null, $ClientBranchId=null)
    {
        $missions = $this->query()
        ->join('mission_occurrences', 'missions.id', '=', 'mission_occurrences.MissionId')
        ->where('scheduled_date', '!=', null);

        $MissionId = $param["MissionId"] ?? null;
        $OccuranceId = $param["OccuranceId"] ?? null;
        $EmpId = $param["EmpId"] ?? null;
        $ClientId = $param["ClientId"] ?? null;
        $ClientBranchId = $param["ClientBranchId"] ?? null;

        $country_id = $param["country_id"] ?? null;
        $state_id = $param["state_id"] ?? null;
        $city_id = $param["city_id"] ?? null;


        $from_date = $param["from_date"] ?? null;
        $to_date = $param["to_date"] ?? null;

        $ItemId = $param["ItemId"] ?? null;
        $StatusId = $param["StatusId"] ?? null;

        $nearestEmployeeIds =  $param["nearestEmployeeIds"] ?? null;
        $nearestClientIds =  $param["nearestClientIds"] ?? null;
        $nearestVehicleIds =  $param["nearestVehicleIds"] ?? null;

        //$MissionId
        $missions = $missions->when($MissionId, function ($query) use ($MissionId) {
            return $query->where('missions.id', $MissionId);
        });
        //$OccuranceId
        $missions = $missions->when($OccuranceId, function ($query) use ($OccuranceId) {
            return $query->where('mission_occurrences.id', $OccuranceId);
        });
        if ($EmpId) {
            if (is_array($EmpId)) {
                $missions = $missions->where(function ($query) use($EmpId) {
                    $query
                    ->where(function ($query) use($EmpId) {
                        $query->whereNull('mission_occurrences.EmpId')
                        ->whereIn('missions.EmpId', $EmpId);
                    })
                    ->orWhere(function ($query) use($EmpId) {
                        $query->whereNotNull('mission_occurrences.EmpId')
                        ->whereIn('mission_occurrences.EmpId', $EmpId);
                    });
                });
            } else {
                $missions = $missions->where(function ($query) use($EmpId)  {
                    $query
                    ->where(function ($query)  use($EmpId) {
                        $query->whereNull('mission_occurrences.EmpId')
                        ->where('missions.EmpId','=', $EmpId);
                    })
                    ->orWhere(function ($query) use($EmpId)  {
                        $query->whereNotNull('mission_occurrences.EmpId')
                        ->where('mission_occurrences.EmpId','=', $EmpId);
                    });
                });
            }
        }
        if ($ClientId && !$ClientBranchId) {
            $missions = $missions->whereHas('client_branch', function ($query) use ($ClientId) {
                $query->where("ClientId", $ClientId);
            });
        }
        if ($ClientBranchId) {
            $missions = $missions->where('ClientBranchId', '=', $ClientBranchId);
        }

        if ($from_date) {
            $missions = $missions->where('mission_occurrences.scheduled_date', '>=', $from_date);
        }
        if ($to_date) {
            $missions = $missions->where('mission_occurrences.scheduled_date', '<=', $to_date);
        }


        //$StatusId
        if ($StatusId) {
            if ($StatusId == 3 || $StatusId == 5) { // completed & re-arranged
                $missions = $missions->where('mission_occurrences.StatusId', '=', $StatusId);
            } elseif ($StatusId == 1) { // New
                $missions = $missions->where('mission_occurrences.scheduled_date', '>', Carbon::today()->addDays(1)->addMillis(-1));
            } elseif ($StatusId == 2) { // Pending
                $missions = $missions
                    ->where('mission_occurrences.scheduled_date', '>=', Carbon::today())
                    ->where('mission_occurrences.scheduled_date', '<=', Carbon::today()->addDays(1)->addMillis(-1))
                    ->whereNotIn('mission_occurrences.StatusId',[3,5]);
            } elseif ($StatusId == 4) { // Expired
                $missions = $missions
                    ->where([
                        ['mission_occurrences.scheduled_date', '<', Carbon::today()],
    //                        ['StatusId', '!=', 2],
    //                        ['StatusId', '!=', 3],
    //                        ['StatusId', '!=', 5],
                    ]);
            }
        }


        //$ItemId
        $missions = $missions->when($ItemId, function ($query) use ($ItemId) {

            return $query->whereHas('tasks', function ($query) use ($ItemId) {
                $query->when($ItemId, function ($query, $item_id) {
                    return $query->where('ItemId', $item_id);
                });
            });
        });

        //$country_id || $state_id || $city_id
        $missions = $missions->when($country_id || $state_id || $city_id
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

        $filtered_missions =clone $missions;

        //$nearestClientIds
        $clientLocations = ClientBranch::Query()
        ->whereHas('client', function ($query) use($nearestClientIds){
            $query->where('id', $nearestClientIds);
        })->select('location as location1');


        $missions = $missions->when($nearestClientIds, function ($query) use($clientLocations,$nearestClientIds) {

            $query->whereHas('client_branch', function($query) use($clientLocations,$nearestClientIds)
            {
                $query->where('ClientId','!=',  $nearestClientIds)
                ->joinSub($clientLocations, 'clientLocations', function ($join) {
                    //$join->on('.id', '=', '.user_id');
                })->whereRaw(DB::raw('(
                    GLength(
                    LineStringFromWKB(
                        LineString(
                            clientLocations.location1,
                            location
                        )
                    )
                    )
                ) <=1'))
                ;
            });
        });


        //$nearestVehicleIds
        $missions = $missions->when($nearestVehicleIds, function ($query) use($filtered_missions,$nearestVehicleIds) {
            $vehicleLocations =  $filtered_missions
            ->whereHas('vehicles', function($query) use($nearestVehicleIds)
            {
            return $query->whereIn('VehicleId', $nearestVehicleIds);
            })
            ->join('client_branches', 'client_branches.id', '=', 'missions.ClientBranchId')
            ->select(\DB::raw('X(client_branches.location) as lat'),\DB::raw('Y(client_branches.location) as lng'));
            //->select(\DB::raw('client_branches.location as location12'));

            $query->whereHas('client_branch', function($query) use($vehicleLocations,$nearestVehicleIds)
        {
            $query//->where('ClientId','!=',  $nearestVehicleIds)
            ->joinSub($vehicleLocations, 'vehicleLocations', function ($join) {
                //$join->on('.id', '=', '.user_id');
            })->whereRaw(DB::raw('(
                GLength(
                    LineStringFromWKB(
                    LineString(
                        Point(vehicleLocations.lat,vehicleLocations.lng),
                        location
                    )
                    )
                )
                ) <=1'))
                ;
        });
    });





        $missions = $missions->when($nearestEmployeeIds, function ($query) use($filtered_missions,$nearestEmployeeIds) {

            $employeeLocations =  $filtered_missions->whereIn('EmpId', $nearestEmployeeIds)
            ->join('client_branches', 'client_branches.id', '=', 'missions.ClientBranchId')
            ->select(\DB::raw('X(client_branches.location) as lat'),\DB::raw('Y(client_branches.location) as lng'));
            //->select(\DB::raw('client_branches.location as location12'));


            $query->whereHas('client_branch', function($query) use($employeeLocations,$nearestEmployeeIds)
            {
                $query->whereNotIn('EmpId', $nearestEmployeeIds)
                ->joinSub($employeeLocations, 'employeeLocations', function ($join) {
                    //$join->on('.id', '=', '.user_id');
                })->whereRaw(DB::raw('(
                    GLength(
                        LineStringFromWKB(
                        LineString(
                            Point(employeeLocations.lat,employeeLocations.lng),
                            location
                        )
                        )
                    )
                    ) <=1'))
                    ;
            });
        });
        // //$nearestVehicleIds
        // $missions = $missions->when($nearestVehicleIds, function ($query) use($item_id) {

        //     return $query->whereHas('tasks', function($query) use($item_id)
        //     {
        //         $query->when($item_id, function ($query, $item_id) {
        //             return $query->where('ItemId', $item_id);
        //         });
        //     });
        // });

        $missions = $missions->orderBy('mission_occurrences.scheduled_date', 'DESC')
        ->select('missions.*',
        'mission_occurrences.id as occurrence_id','mission_occurrences.scheduled_date',
        'mission_occurrences.EmpId as occurrence_EmpId','mission_occurrences.StatusId as occurrence_StatusId')
        ->get();
        $missions = $missions->map(function($item) {
            $item->id = $item->occurrence_id;
            $item->StatusId = $item->StatusId;
            $item->start_date =  $item->scheduled_date;
            if($item->occurrence_EmpId)
            {
                $item->EmpId =  $item->occurrence_EmpId;
            }
            unset($item->occurrence_id,$item->scheduled_date,$item->occurrence_StatusId, $item->occurrence_EmpId);
            return $item;
        });
        return $missions;
    }



    public function setActive($missionId, $EmpId)
    {
        $this->query()->where('EmpId', '=', $EmpId)
            ->update([
                'is_currently_active' => 0
            ]);
        $this->query()->where('id', '=', $missionId)
            ->update([
                'is_currently_active' => 1
            ]);
    }

}
