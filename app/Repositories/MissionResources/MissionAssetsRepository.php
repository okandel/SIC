<?php

namespace App\Repositories\MissionAssets;


use App\MissionAsset;

use App\Repositories\BaseRepository;   
class MissionAssetsRepository extends BaseRepository implements MissionAssetsRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(MissionAsset::Query()); 
    }  

    public function list($MissionId)
    {
        $assets = $this->query()->where('MissionId', '=', $MissionId);
        return $assets;
    }
 
}