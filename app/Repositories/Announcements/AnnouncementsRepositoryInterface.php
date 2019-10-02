<?php

namespace App\Repositories\Announcements;

interface AnnouncementsRepositoryInterface
{
    public function get($id,$fail=true);

    public function list();

    public function create(array $announcement_array);

    public function update($id, array $announcement_array);

    public function delete($id);

}