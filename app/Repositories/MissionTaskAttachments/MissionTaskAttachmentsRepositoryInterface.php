<?php

namespace App\Repositories\MissionTaskAttachments;

interface MissionTaskAttachmentsRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($MissionId=null, $TaskId=null);

    public function create(array $attachment_array);

    public function update($id, array $attachment_array);

    public function delete($id);

}