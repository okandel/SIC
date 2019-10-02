<?php

namespace App\Repositories\Announcements;

use App\Announcement;

use App\Repositories\BaseRepository;   
class AnnouncementsRepository extends BaseRepository implements AnnouncementsRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Announcement::Query());
    }

    public function list()
    {
        $tasks = $this->query();

        $tasks = $tasks->get();
        return $tasks;
    }
}