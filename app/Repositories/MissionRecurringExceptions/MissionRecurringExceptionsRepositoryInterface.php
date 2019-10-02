<?php

namespace App\Repositories\MissionRecurringExceptions;


interface MissionRecurringExceptionsRepositoryInterface
{
    public function get($id, $fail = true);

    public function list($MissionId = null, $type = null, $MissionId_search = null);

    public function create(array $exception_array);

    public function update($id, array $exception_array);

    public function delete($id);

}