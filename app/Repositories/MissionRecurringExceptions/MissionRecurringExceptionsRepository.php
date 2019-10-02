<?php

namespace App\Repositories\MissionRecurringExceptions;


use App\MissionRecurringException;

use App\Repositories\BaseRepository;   
class MissionRecurringExceptionsRepository extends BaseRepository implements MissionRecurringExceptionsRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(MissionRecurringException::Query());
    }

    public function list($MissionId = null, $type = null, $MissionId_search = null)
    {
        $exceptions = $this->query();

        if ($MissionId) {
            $exceptions = $exceptions->where('MissionId', $MissionId);
        }

        if ($type) {
            $exceptions = $exceptions->where('exception_type', $type);
        }

        if ($MissionId_search) {
            $exceptions = $exceptions->where('MissionId', $MissionId_search);
        }

        $exceptions = $exceptions->get();

        return $exceptions;
    }

}