<?php

namespace App\Repositories\Clients;

use App\Client;
use App\Repositories\BaseRepository;
class ClientsRepository extends BaseRepository implements ClientsRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(Client::Query()); 
    }
  
    public function list(array $param = [])
    //$contact_person=null,$email=null,$phone=null,$status="" ,$country_id=null,$State_id=null,$City_id=null)
    {
        $clients =$this->query();
        
        $client_id = $param["client_id"] ?? null;
        $contact_person = $param["contact_person"] ?? null;
        $email = $param["email"] ?? null;
        $phone = $param["phone"] ?? null;
        $status = $param["status"] ?? null;

        $item_id = $param["item_id"] ?? null;
        
        $country_id = $param["country_id"] ?? null;
        $state_id = $param["state_id"] ?? null;
        $city_id = $param["city_id"] ?? null;
 

        if ($contact_person)
        {
            $clients = $clients->where('contact_person', 'like', '%'.$contact_person.'%');
        }if ($email)
        {
            $clients = $clients->where('email', 'like', '%'.$email.'%');
        }if ($phone)
        {
            $clients = $clients->where('phone', 'like', '%'.$phone.'%');
        } 
        if ($status!= "")
        {
            $clients = $clients->where('IsApproved', $status);
        }
        //$item_id
        $clients = $clients->when($client_id, function ($query) use($client_id) { 
            return $query->where('id', $client_id);  
        });
        //$item_id
        $clients = $clients->when($item_id, function ($query) use($item_id) {
            
                return $query->whereHas('branches.missions.tasks', function($query) use($item_id)
                { 
                    $query->when($item_id, function ($query, $item_id) {
                        return $query->where('ItemId', $item_id);
                    }); 
                });
        });
        
        //$country_id || $state_id || $city_id
        $clients = $clients->when($country_id || $state_id || $city_id
            , function ($query) use($country_id,$state_id,$city_id) {
            
                return $query->whereHas('branches', function($query) use($country_id,$state_id,$city_id)
                { 
                    $query->when($country_id, function ($query, $country_id) {
                        return $query->where('CountryId', $country_id);
                    }) 
                    ->when($state_id, function ($query, $state_id) {
                        return $query->where('StateId', $state_id);
                    }) 
                    ->when($city_id, function ($query, $city_id) {
                        return $query->where('CityId', $city_id);
                    }); 
                }); 

        });  
        $clients = $clients->get();
        return $clients;
    }

    
}