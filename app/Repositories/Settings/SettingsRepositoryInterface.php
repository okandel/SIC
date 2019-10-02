<?php

namespace App\Repositories\Settings;


interface SettingsRepositoryInterface
{
    public function get($id,$fail=true);

    public function list();

    public function create(array $setting_array);

    public function update($id, array $setting_array);

    public function delete($id);

}