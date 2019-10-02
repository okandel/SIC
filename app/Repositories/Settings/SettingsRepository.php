<?php

namespace App\Repositories\Settings;


use App\Setting;

use App\Repositories\BaseRepository;   
class SettingsRepository extends BaseRepository implements SettingsRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(Setting::Query()); 
    } 

    public function list()
    { 
        $settings = $this->getAll();
        return $settings;
    } 
}