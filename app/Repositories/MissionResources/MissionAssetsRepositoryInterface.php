<?php

namespace App\Repositories\MissionAssets;

interface MissionAssetsRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($MissionId);

    public function create(array $asset_array);

    public function update($id, array $asset_array);

    public function delete($id);

}